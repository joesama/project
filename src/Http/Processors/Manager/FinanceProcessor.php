<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\FinanceMilestone;
use Joesama\Project\Database\Repositories\Project\MilestoneRepository;
use Joesama\Project\Http\Services\DataGridGenerator;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Project Milestone
 *
 * @package default
 * @author 
 **/
class FinanceProcessor 
{
	use HasAccessAs;

	private $modelObj, $milestoneRepository, $formBuilder, $viewBuilder;

	/**
	 * Initiate Class Contructor
	 * 
	 * @param PhysicalMilestone $model       Model 
	 * @param FormGenerator     $formBuilder Form Builder
	 * @param ViewGenerator     $viewBuilder View Builder
	 */
	public function __construct(
		FinanceMilestone $model,
		MilestoneRepository $milestoneRepository,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder
	){
		$this->modelObj = $model;
		$this->milestoneRepository = $milestoneRepository;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
	}

	/**
	 * Finance Milestone List
	 * 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $projectId   [description]
	 * @return [type]               [description]
	 */
	public function list(Request $request, int $corporateId, int $projectId)
	{
		$columns = [
		   [ 'field' => 'label',
		   'title' => __('joesama/project::form.project_milestone_finance.label'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'planned_amount',
		   'title' => __('joesama/project::form.project_milestone_finance.planned'),
		   'style' => 'text-center text-bold'],
		   [ 'field' => 'actual_amount',
		   'title' => __('joesama/project::form.project_milestone_finance.actual'),
		   'style' => 'text-center text-bold']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/finance/milestone/'.$corporateId.'/'.$projectId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/finance/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.finance.milestone') )
				 ->buildDataModel(
				 	route('api.list.finance',[$corporateId, $request->segment(5)]), 
				 	$this->milestoneRepository->financeList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE);

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.finance.milestone',[$corporateId,$projectId]));
		}

		$table = $datagrid->render();

		return compact('table');
	}

	/**
	 * Physical Progress Milestone
	 * 
	 * @param  Request $request     HTTP Request
	 * @param  int     $corporateId Corporate Id
	 * @param  int     $projectId   Project Id
	 * @return [type]               [description]
	 */
	public function milestone(Request $request, int $corporateId, int $projectId)
	{
		$tags = ($request->segment(6)) ? $this->modelObj->find($request->segment(6))->tags->pluck('label')->implode(',') : 'main';

		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
						'project_id' => $request->segment(5)
				])->extras([
					'group' => 'tag'
				])->default([
					'group' => $tags,
				])
				->id($request->segment(6))
				->required(['label','weightage'])
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.finance.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}


} // END class MakeProjectProcessor 