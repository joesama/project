<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Http\Services\DataGridGenerator;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class ListProcessor 
{

	public function __construct(
		ProjectInfoRepository $projectInfo
	){
		$this->projectObj = $projectInfo;
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function project($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::project.info.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'profile.name',
		   'title' => 'PIC',
		   'style' => 'text-xs-left'],
		   [ 'field' => 'contract',
		   'title' => __('joesama/project::project.info.contract.no'),
		   'style' => 'text-xs-left'],
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::project.info.contract.date.start'),
		   'style' => 'text-xs-left date'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::project.info.contract.date.end'),
		   'style' => 'text-xs-left date']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/project/view/'.$corporateId), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => handles('joesama/project::manager/project/form/'.$corporateId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.project') )
				 ->buildDataModel(
				 	route('api.list.project',$corporateId), 
				 	$this->projectObj->projectList($corporateId)
				 )->buildAddButton(route('manager.project.form',$corporateId))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function task($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.task.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'assignee.name',
		   'title' => 'PIC',
		   'style' => 'text-left'],
		   [ 'field' => 'progress.progress',
		   'title' => __('joesama/project::form.task.progress'),
		   'style' => 'text-center'],
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::form.task.start'),
		   'style' => 'text-center date hidden'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::form.task.end'),
		   'style' => 'text-center date hidden']
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
			    'url' => handles('joesama/project::manager/task/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		if($request->segment(5)){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/task/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.task') )
				 ->buildDataModel(
				 	route('api.list.task',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectTask($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.task.form',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function issue($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'description',
		   'title' => __('joesama/project::project.issues.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'assignee.name',
		   'title' => 'PIC',
		   'style' => 'text-xs-center col-xs-3'],
		   [ 'field' => 'progress.description',
		   'title' => __('joesama/project::project.issues.status'),
		   'style' => 'text-xs-center col-xs-2']
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
			    'url' => handles('joesama/project::manager/issue/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		if($request->segment(5)){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/issue/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.issue') )
				 ->buildDataModel(
				 	route('api.list.issue',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIssue($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.issue.form',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function risk($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'description',
		   'title' => __('joesama/project::project.risk.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'severity.description',
		   'title' => __('joesama/project::project.risk.severity'),
		   'style' => 'text-xs-center col-xs-2']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.view') , // Action Description
			    'url' => handles('joesama/project::manager/risk/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		if($request->segment(5)){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/risk/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.risk') )
				 ->buildDataModel(
				 	route('api.list.risk',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectRisk($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.risk.form',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function incident($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'type.description',
		   'title' => __('joesama/project::form.project_incident.incident_id'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'incident',
		   'title' => __('joesama/project::form.project_incident.incident'),
		   'style' => 'text-center'],
		   [ 'field' => 'reporter.name',
		   'title' => __('joesama/project::form.project_incident.report'),
		   'style' => 'text-left'],
		   [ 'field' => 'report_date',
		   'title' => __('joesama/project::form.project_incident.date'),
		   'style' => 'text-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/hse/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::manager.hse.list') )
				 ->buildDataModel(
				 	route('api.list.incident',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIncident($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.hse.form',[$corporateId, $request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}
} // END class MakeProjectProcessor 