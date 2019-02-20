<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\PhysicalMilestone;
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
class PhysicalProcessor 
{
	use HasAccessAs;

	private $modelObj, $milestoneRepository, $formBuilder, $viewBuilder;

	/**
	 * Initiate Class Contructor
	 * 
	 * @param PhysicalMilestone   $model               Model
	 * @param MilestoneRepository $milestoneRepository Milestone Repository
	 * @param FormGenerator       $formBuilder         Form Builder
	 * @param ViewGenerator       $viewBuilder         View Builder
	 */
	public function __construct(
		PhysicalMilestone $model,
		MilestoneRepository $milestoneRepository,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder
	){
		$this->modelObj = $model;
		$this->milestoneRepository = $milestoneRepository;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->profile();
	}

	/**
	 * Physical Milestone List
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
		   'title' => __('joesama/project::form.project_milestone_physical.label'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'planned',
		   'title' => __('joesama/project::form.project_milestone_physical.planned'),
		   'style' => 'text-center text-bold'],
		   [ 'field' => 'actual',
		   'title' => __('joesama/project::form.project_milestone_physical.actual'),
		   'style' => 'text-center text-bold']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/physical/milestone/'.$corporateId.'/'.$projectId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/physical/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.physical.milestone') )
				 ->buildDataModel(
				 	route('api.list.physical',[$corporateId, $request->segment(5)]), 
				 	$this->milestoneRepository->physicalList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE);

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.physical.milestone',[$corporateId,$projectId]));
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
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
						'project_id' => $request->segment(5)
				])
				->id($request->segment(6))
				->required(['planned']);
				
		if($request->segment(6)){
			$form->excludes(['progress_date'])
				   ->readonly(['label']);
		}

		$form = $form->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.physical.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}


} // END class MakeProjectProcessor 