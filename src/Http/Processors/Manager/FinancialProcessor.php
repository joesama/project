<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\ProjectPayment;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Http\Services\DataGridGenerator;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class FinancialProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		ProjectInfoRepository $projectInfo,
		ProjectPayment $payment
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $payment;
		$this->projectObj = $projectInfo;
	}

	/**
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
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$table = $datagrid->buildTable($columns, __('joesama/project::manager.financial.list') )
				 ->buildDataModel(
				 	route('api.list.payment',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectPayment($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.financial.payment',[$corporateId, $request->segment(5)]))
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
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' => $request->segment(5),
					'claim_report_by' => auth()->id(),
					'paid_report_by' => null,
					'paid_date' => null,
					'paid_amount' => null,
				])
				->id($request->segment(5))
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
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' => $request->segment(5),
					'paid_report_by' => auth()->id(),
				])
				->readonly([
					'claim_amount','claim_date'
				])
				->id($request->segment(6))
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
// dd($form);
		return compact('form');

	}

} // END class MakeProjectProcessor 