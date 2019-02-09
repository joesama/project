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
		   [ 'field' => 'paid_date',
		   'title' => __('joesama/project::form.project_payment.paid_date'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'claim_amount',
		   'title' => __('joesama/project::form.project_payment.claim_amount'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'paid_amount',
		   'title' => __('joesama/project::form.project_payment.paid_amount'),
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
		$project = $this->projectObj->getProject($request->segment(5));

		$tags = ($request->segment(6)) ? $this->modelObj->find($request->segment(6))->tags->pluck('label')->implode(',') : 'main';

		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' 		=> 	$request->segment(5),
					'claim_report_by' 	=> 	auth()->id(),
					'paid_report_by' 	=> 	null,
					'paid_date' 		=> 	null,
					'paid_amount' 		=> 	null,
					'reference' 		=> 	null,
				])->extras([
					'group' => 'tag'
				])->default([
					'group' => $tags,
				])
				->id($request->segment(5))
				->required(['claim_date','claim_amount','group'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.claim',[
						$corporateId, 
						$request->segment(5), 
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
		$tags = 'main';

		if($request->segment(6)){
			$tagCollection = $this->modelObj->find($request->segment(6))->tags;
			$tags = ($tagCollection->isNotEmpty()) ? $tagCollection->pluck('label')->implode(',') : $tags;
		}

		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' => $request->segment(5),
					'paid_report_by' => auth()->id(),
				])
				->readonly([
					'claim_amount','claim_date','group'
				])->extras([
					'group' => 'tag'
				])->default([
					'group' => $tags,
				])
				->id($request->segment(6))
				->required(['paid_date','paid_amount'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.payment',[
						$corporateId, 
						$request->segment(5), 
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
				])
				->id($request->segment(6))
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
		$form = $this->formBuilder
				->newModelForm($this->retentionObj)
				->mapping([
					'project_id' => $request->segment(5),
					'report_by' => auth()->id()
				])
				->id($request->segment(6))
				->required(['*'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.financial.retention',[
						$corporateId, 
						$request->segment(5), 
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
		$form = $this->formBuilder
				->newModelForm($this->ladObj)
				->mapping([
					'project_id' => $request->segment(5),
					'report_by' => auth()->id()
				])
				->id($request->segment(6))
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

} // END class MakeProjectProcessor 