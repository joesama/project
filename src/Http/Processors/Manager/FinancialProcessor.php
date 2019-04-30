<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\ProjectLad;
use Joesama\Project\Database\Model\Project\ProjectPayment;
use Joesama\Project\Database\Model\Project\ProjectRetention;
use Joesama\Project\Database\Model\Project\ProjectVo;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Http\Services\DataGridGenerator;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class FinancialProcessor 
{
	use HasAccessAs;

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		ProjectInfoRepository $projectInfo,
		ProjectPayment $payment,
		ProjectVo $vo,
		ProjectRetention $retention,
		ProjectLad $lad
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $payment;
		$this->voObj = $vo;
		$this->retentionObj = $retention;
		$this->ladObj = $lad;
		$this->projectObj = $projectInfo;
		$this->profile();
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$view = $this->viewBuilder->newView($this->modelObj)
		->relation([
			'project_id' => 'project.name',
		])
		->id($request->segment(6))
		->excludes(['report_id','card_id'])
		->renderView(
			__('joesama/project::'.$request->segment(1).'.'
				.$request->segment(2).'.'
				.$request->segment(3))
		);

		return compact('view');
	}

	/**
	 * List of payment
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$columns = [
		   [ 'field' => 'claim_date',
		   'title' => __('joesama/project::form.project_payment.claim_date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'payment_date',
		   'title' => __('joesama/project::form.project_payment.paid_date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'claim_amount',
		   'title' => __('joesama/project::form.project_payment.claim_amount'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'paid_amount',
		   'title' => __('joesama/project::form.project_payment.paid_amount'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'recipient.name',
		   'title' => __('joesama/project::form.project_payment.client_id'),
		   'style' => 'text-xs-left  text-capitalize'],
		   [ 'field' => 'reference',
		   'title' => __('joesama/project::form.project_payment.reference'),
		   'style' => 'text-xs-center']
		];

		if(is_null($request->segment(5))){
			$columns = array_merge($columns,[[ 
				'field' => 'project.name',
		   		'title' => __('joesama/project::form.task.project_id'),
		   		'style' => 'text-xs-center col-xs-3'
		   	]]);
		}

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/financial/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		if($request->segment(5)){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/financial/payment/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/financial/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$table = $datagrid->buildTable($columns, __('joesama/project::manager.financial.list') )
				 ->buildDataModel(
				 	route('api.list.payment',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectPayment($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.financial.claim',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();

		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function claim(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$dataQuery = $this->getClientListing($projectId);

		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' 		=> 	$projectId,
					'claim_report_by' 	=> 	$this->profile()->id,
					'paid_report_by' 	=> 	null,
					'paid_date' 		=> 	null,
					'paid_amount' 		=> 	null,
					'reference' 		=> 	null,
					'remark_payment' 		=> 	null,
				])->extras([
					'remark_claim' => 'textarea',
					'client_id' => $dataQuery->get('client')->pluck('name','id')
				])->default([
					'claim_date' => $dataQuery->get('start')
				])->id($projectId)
				->required(['claim_date','claim_amount','remark_claim'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.claim',[
						$corporateId, 
						$projectId, 
						$request->segment(6)]
					)
				);

		return compact('form');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function payment(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$dataQuery = $this->getClientListing($projectId, 'claim', $request->segment(6));

		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' => $projectId,
					'paid_report_by' => $this->profile()->id,
				])
				->readonly([
					'claim_amount','claim_date','remark_claim'
				])->excludes([
					'remark_claim'
				])->extras([
					'remark_payment' => 'textarea',
					'client_id' => $dataQuery->get('client')->pluck('name','id'),
				])->default([
					'paid_amount' => $dataQuery->get('amount'),
					'paid_date' => $dataQuery->get('start')
				])
				->id($request->segment(6))
				->required(['paid_date','paid_amount','client_id','remark_payment'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.payment',[
						$corporateId, 
						$projectId, 
						$request->segment(6)]
					)
				);

		return compact('form');
	}

	/**
	 * Manage VO 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $projectId   [description]
	 * @return [type]               [description]
	 */
	public function vo(Request $request, int $corporateId)
	{
		$columns = [
		   [ 'field' => 'date',
		   'title' => __('joesama/project::form.project_vo.date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'amount',
		   'title' => __('joesama/project::form.project_vo.amount'),
		   'style' => 'text-xs-center'],
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/financial/voform/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/financial/vodelete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
				    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$table = $datagrid->buildTable($columns, __('joesama/project::manager.financial.vo') )
				 ->buildDataModel(
				 	route('api.list.vo',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectVo($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.financial.voform',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();

		return compact('table');
	}


	/**
	 * VO Form
	 **/
	public function voform(Request $request, int $corporateId)
	{
		$form = $this->formBuilder
				->newModelForm($this->voObj)
				->mapping([
					'project_id' => $request->segment(5),
					'report_by' => auth()->id()
				])->extras([
					'remark' => 'textarea'
				])->id($request->segment(6))
				->required(['*'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.vo',[
						$corporateId, 
						$request->segment(5), 
						$request->segment(6)]
					)
				);

		return compact('form');
	}


	/**
	 * Manage Retention 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $projectId   [description]
	 * @return [type]               [description]
	 */
	public function retention(Request $request, int $corporateId)
	{
		$columns = [
		   [ 'field' => 'date',
		   'title' => __('joesama/project::form.project_retention.date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'amount',
		   'title' => __('joesama/project::form.project_retention.amount'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'recipient.name',
		   'title' => __('joesama/project::form.project_retention.client_id'),
		   'style' => 'text-xs-left  text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/financial/retentionform/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/financial/retentiondelete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
				    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();

		$table = $datagrid->buildTable($columns, __('joesama/project::manager.financial.retention') )
				 ->buildDataModel(
				 	route('api.list.retention',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectRetention($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.financial.retentionform',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();

		return compact('table');
	}


	/**
	 * Retention Form
	 **/
	public function retentionform(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$dataQuery = $this->getClientListing($projectId);

		$form = $this->formBuilder
				->newModelForm($this->retentionObj)
				->mapping([
					'project_id' => $projectId,
					'report_by' => $this->profile()->id
				])->extras([
					'remark' => 'textarea',
					'client_id' => $dataQuery->get('client')->pluck('name','id'),
				])
				->id($request->segment(6))
				->default([
					'date' => $dataQuery->get('start')
				])
				->required(['*'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.retention',[
						$corporateId, 
						$projectId, 
						$request->segment(6)]
					)
				);

		return compact('form');
	}

	/**
	 * Manage LAD 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $projectId   [description]
	 * @return [type]               [description]
	 */
	public function lad(Request $request, int $corporateId)
	{
		$columns = [
		   [ 'field' => 'date',
		   'title' => __('joesama/project::form.project_lad.date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'amount',
		   'title' => __('joesama/project::form.project_lad.amount'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'recipient.name',
		   'title' => __('joesama/project::form.project_retention.client_id'),
		   'style' => 'text-xs-left  text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/financial/ladform/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/financial/laddelete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
				    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$table = $datagrid->buildTable($columns, __('joesama/project::manager.financial.lad') )
				 ->buildDataModel(
				 	route('api.list.lad',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectLad($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.financial.ladform',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();

		return compact('table');
	}


	/**
	 * LAD Form
	 **/
	public function ladform(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$dataQuery = $this->getClientListing($projectId);

		$form = $this->formBuilder
				->newModelForm($this->ladObj)
				->mapping([
					'project_id' => $request->segment(5),
					'report_by' => $this->profile()->id
				])->extras([
					'remark' => 'textarea',
					'client_id' => $dataQuery->get('client')->pluck('name','id'),
				])
				->id($request->segment(6))
				->default([
					'date' => $dataQuery->get('start')
				])
				->required(['*'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.lad',[
						$corporateId, 
						$request->segment(5), 
						$request->segment(6)]
					)
				);

		return compact('form');
	}

	/**
	 * Get Client Listing For Payment
	 * 
	 * @param  int    $projectId
	 * @return Illuminate\Support\Collection
	 */
	protected function getClientListing(int $projectId, ?string $claimName = NULL, ?int $claimId = NULL)
	{
		$project = $this->projectObj->getProject($projectId);

		$client = data_get($project,'client');

		$amount = $claimName != NULL ? data_get($project,$claimName)->where('id',$claimId)->first()->claim_amount : NULL;

		return collect([
			'client' => collect(data_get($project,'partner'))->push($client),
			'amount' => $amount,
			'start' => $project->start,
			'end' => $project->end
		]);
	}

} // END class MakeProjectProcessor 