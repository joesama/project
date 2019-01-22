<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Services\DataGridGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class ListProcessor 
{
	use HasAccessAs;

	private $projectObj, $approvalObj, $reportCardObj;

	/**
	 * Build Class Dependency
	 * 
	 * @param ProjectInfoRepository    $projectInfo Repository for project info
	 * @param ReportCardInfoRepository $reportCard  Repository for report card
	 */
	public function __construct (
		ProjectInfoRepository $projectInfo,
		ProjectWorkflowRepository $projectWorkflow,
		ReportCardInfoRepository $reportCard
	){
		$this->projectObj = $projectInfo;
		$this->approvalObj = $projectWorkflow;
		$this->reportCardObj = $reportCard;
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
		   [ 'field' => 'manager.0.name',
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
			    'key' => 'id'  ]
		];

		if($this->isProjectManager() || auth()->user()->isAdmin){

			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/project/form/'.$corporateId), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);

		}


		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::project.list.project') )
				 ->buildDataModel(
				 	route('api.list.project',$corporateId), 
				 	$this->projectObj->projectList($corporateId)
				 );

		if($this->wasProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.project.form',$corporateId));
		}
		
		return $datagrid->buildOption($action, TRUE)->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function projectApproval($request, int $corporateId)
	{

		$columns = [
		   [ 'field' => 'generation_date',
		   'title' => __('joesama/project::form.report.report_date'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'project.name',
		   'title' => __('joesama/project::project.info.name'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'status.description',
		   'title' => 'Status',
		   'style' => 'text-center text-bold']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/project/view/'.$corporateId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'project_id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.workflow.approval') )
				 ->buildDataModel(
				 	route('api.list.approval',[$corporateId, $request->segment(5)]), 
				 	$this->approvalObj->projectApprovalList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE);

		return $datagrid->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function monthlyReport($request, int $corporateId)
	{

		$columns = [
		   [ 'field' => 'generation_date',
		   'title' => __('joesama/project::form.report.report_date'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'project.name',
		   'title' => __('joesama/project::project.info.name'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'month',
		   'title' => 'Month',
		   'style' => 'text-center text-bold'],
		   [ 'field' => 'status.description',
		   'title' => 'Status',
		   'style' => 'text-center text-bold']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::report/monthly/form/'.$corporateId.'/'.$request->segment(5,'report')), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::report.monthly.list') )
				 ->buildDataModel(
				 	route('api.list.monthly',[$corporateId, $request->segment(5)]), 
				 	$this->reportCardObj->monthlyList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE);

		if($this->isProjectManager()){
			$datagrid->buildAddButton(
				route('report.monthly.form',[$corporateId, $request->segment(5)]),
				__('joesama/project::report.monthly.form')
			);
		}

		return $datagrid->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function weeklyReport($request, int $corporateId)
	{

		$columns = [
		   [ 'field' => 'generation_date',
		   'title' => __('joesama/project::form.report.report_date'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'project.name',
		   'title' => __('joesama/project::project.info.name'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'week',
		   'title' => 'Week',
		   'style' => 'text-center text-bold'],
		   [ 'field' => 'status.description',
		   'title' => 'Status',
		   'style' => 'text-center text-bold']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::report/weekly/form/'.$corporateId.'/'.$request->segment(5,'report')), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::report.weekly.list') )
				 ->buildDataModel(
				 	route('api.list.weekly',[$corporateId, $request->segment(5)]), 
				 	$this->reportCardObj->weeklyList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE);

		if ( $this->isProjectManager() ){
			$datagrid->buildAddButton(
				route('report.weekly.form',[$corporateId, $request->segment(5)]),
				__('joesama/project::report.weekly.form')
			);
		}

		return $datagrid->render();
	}

	/**
	 * Generate Task Datagrid
	 * 
	 * @param  Request      $request     HTTP Request
	 * @param  int         	$corporateId Corporate Id
	 * @param  int|integer 	$hasAction   Can Create New Task
	 * @return view                   
	 */
	public function task($request, int $corporateId, ?int $hasAction = 1)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.task.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'assignee.name',
		   'title' => 'PIC',
		   'style' => 'text-left'],
		   [ 'field' => 'effective_days',
		   'title' => __('joesama/project::form.task.effective_days'),
		   'style' => 'text-center'],
		   [ 'field' => 'progress.progress',
		   'title' => __('joesama/project::form.task.progress'),
		   'style' => 'text-center'],
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::form.task.start'),
		   'style' => 'text-center date'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::form.task.end'),
		   'style' => 'text-center date']
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

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/task/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::project.list.task') )
				 ->buildDataModel(
				 	route('api.list.task',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectTask($corporateId, $request->segment(5))
				 );

		if ( ( $this->isProjectManager() || auth()->user()->isAdmin ) && $hasAction ) {
			$datagrid->buildAddButton(route('manager.task.form',[$corporateId, $request->segment(5)]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
	}

	/**
	 * Generate Issue Datagrid
	 * 
	 * @param  Request      $request     HTTP Request
	 * @param  int         	$corporateId Corporate Id
	 * @param  int|integer 	$hasAction   Can Create New Issue
	 * @return view                   
	 */
	public function issue($request, int $corporateId, ?int $hasAction = 1)
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

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/issue/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::project.list.issue') )
				 ->buildDataModel(
				 	route('api.list.issue',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIssue($corporateId, $request->segment(5))
				 );

		if ( ( $this->isProjectManager() || auth()->user()->isAdmin ) && $hasAction ) {
			$datagrid->buildAddButton(route('manager.issue.form',[$corporateId, $request->segment(5)]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
	}

	/**
	 * Generate Risk Datagrid
	 * 
	 * @param  Request      $request     HTTP Request
	 * @param  int         	$corporateId Corporate Id
	 * @param  int|integer 	$hasAction   Can Create New Issue
	 * @return view                   
	 */
	public function risk($request, int $corporateId, ?int $hasAction = 1)
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

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/risk/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::project.list.risk') )
				 ->buildDataModel(
				 	route('api.list.risk',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectRisk($corporateId, $request->segment(5))
				 );

		if ( ( $this->isProjectManager() || auth()->user()->isAdmin ) && $hasAction ) {
			$datagrid->buildAddButton(route('manager.risk.form',[$corporateId, $request->segment(5)]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
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
		
		$datagrid->buildTable($columns, __('joesama/project::manager.hse.list') )
				 ->buildDataModel(
				 	route('api.list.incident',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIncident($corporateId, $request->segment(5))
				 );

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.hse.form',[$corporateId, $request->segment(5)]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function partner($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.project_partner.partner_id'),
		   'style' => 'text-left text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/partner/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.partner.list') )
				 ->buildDataModel(
				 	route('api.list.partner',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectPartner($corporateId, $request->segment(5))
				 );

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.partner.form',[$corporateId, $request->segment(5)]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
	}

	/**
	 * [attribute description]
	 * @param  Request $request    Http request
	 * @param  int    $corporateId Corporate Id
	 * @param  int    $projectId   Project Id
	 * @return mixed              
	 */
	public function attribute($request, int $corporateId, int $projectId)
	{

		$columns = [
		   [ 'field' => 'variable',
		   'title' => __('joesama/project::form.project_attribute.variable'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'data',
		   'title' => __('joesama/project::form.project_attribute.data'),
		   'style' => 'text-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/attribute/form/'.$corporateId.'/'.$projectId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.attribute.list') )
				 ->buildDataModel(
				 	route('api.list.attribute',[$corporateId, $projectId]), 
				 	$this->projectObj->listProjectAttribute($corporateId, $projectId)
				 );

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$datagrid->buildAddButton(route('manager.attribute.form',[$corporateId, $projectId]));
		}

		return $datagrid->buildOption($action, TRUE)->render();
	}
} // END class MakeProjectProcessor 