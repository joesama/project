<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectUploadRepository;
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

	private $projectObj,
		$approvalObj,
		$reportCardObj,
		$uploadObj;

	/**
	 * Build Class Dependency
	 * 
	 * @param ProjectInfoRepository    $projectInfo Repository for project info
	 * @param ReportCardInfoRepository $reportCard  Repository for report card
	 */
	public function __construct (
		ProjectInfoRepository $projectInfo,
		ProjectWorkflowRepository $projectWorkflow,
		ReportCardInfoRepository $reportCard,
		ProjectUploadRepository $uploadObj
	){
		$this->projectObj = $projectInfo;

		$this->approvalObj = $projectWorkflow;

		$this->reportCardObj = $reportCard;

		$this->uploadObj = $uploadObj;

		$this->profile();
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
		   'title' => __('joesama/project::form.report.submit_date'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'project.name',
		   'title' => __('joesama/project::project.info.name'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'aging_action',
		   'title' => __('joesama/project::form.report.aging'),
		   'style' => 'text-center text-capitalize'],
		   [ 'field' => 'state',
		   'title' => 'Status',
		   'style' => 'text-center text-bold text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::manager/project/view/'.$corporateId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'project_id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.workflow.approval-'.$request->segment(2)) )
				 ->buildDataModel(
				 	route('api.list.approval-'.$request->segment(2),[$corporateId]), 
				 	$this->approvalObj->projectApprovalList($request,$corporateId)
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
			    'url' => handles('joesama/project::manager/project/view/'.$corporateId.'/'.$request->segment(5,'report')), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::report.monthly.list') )
				 ->buildDataModel(
				 	route('api.list.monthly',[$corporateId, $request->segment(5)]), 
				 	$this->reportCardObj->monthlyList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE)->render();
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
		
		return $datagrid->buildTable($columns, __('joesama/project::report.weekly.list') )
				 ->buildDataModel(
				 	route('api.list.weekly',[$corporateId, $request->segment(5)]), 
				 	$this->reportCardObj->weeklyList($corporateId, $request->segment(5))
				 )
				 ->buildOption($action, TRUE)->render();
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
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::form.task.start'),
		   'style' => 'text-center date'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::form.task.end'),
		   'style' => 'text-center date'],
		   [ 'field' => 'effective_days',
		   'title' => __('joesama/project::form.task.effective_days'),
		   'style' => 'text-center'],
//		   [ 'field' => 'taskstat.description',
//		   'title' => __('joesama/project::form.task.status_id'),
//		   'style' => 'text-center text-capitalize'],
		   [ 'field' => 'progress.progress',
		   'title' => __('joesama/project::form.task.progress'),
		   'style' => 'text-center']
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
				    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/task/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
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

	        $datagrid->buildExtraButton([
	            ['uri' => route('manager.plan.form',[$corporateId,$request->segment(5)]),'desc' => trans('joesama/project::project.task.plan')]
	        ]);

	        $datagrid->buildOption($action, TRUE);
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
	public function plan($request, int $corporateId, ?int $hasAction = 1)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.plan.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'description',
		   'title' =>  __('joesama/project::form.plan.description'),
		   'style' => 'text-left'],
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::form.task.start'),
		   'style' => 'text-center date'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::form.task.end'),
		   'style' => 'text-center date'],
		   [ 'field' => 'effective_days',
		   'title' => __('joesama/project::form.task.effective_days'),
		   'style' => 'text-center']
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
			    'url' => handles('joesama/project::manager/plan/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		if($this->isProjectManager() || auth()->user()->isAdmin){
			$editAction = [
				[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
				    'url' => handles('joesama/project::manager/plan/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'psi-file-edit icon', // Icon for action : optional
				    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/plan/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
				    'key' => 'id'  ]
			];

			$action = array_merge($action,$editAction);
		}

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::project.list.plan') )
				 ->buildDataModel(
				 	route('api.list.plan',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectPlan($corporateId, $request->segment(5))
				 );

		if ( ( $this->isProjectManager() || auth()->user()->isAdmin ) && $hasAction ) {
			$datagrid->buildAddButton(route('manager.plan.form',[$corporateId, $request->segment(5)]));
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
		   [ 'field' => 'label',
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
				    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/issue/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
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
			$datagrid->buildOption($action, TRUE);
		}

		return $datagrid->render();
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
			'style' => 'text-xs-center col-xs-2'],
			[ 'field' => 'status.description',
			'title' => __('joesama/project::project.risk.status'),
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
				    'key' => 'id'  ],
				[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
				    'url' => handles('joesama/project::api/risk/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
				    'icons' => 'fa fa-remove icon', // Icon for action : optional
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
			$datagrid->buildOption($action, TRUE);
		}

		return $datagrid->render();
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
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/incident/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
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

	/**
	 * Upload Listing
	 * 
	 * @param  Request $request    Http request
	 * @param  int    $corporateId Corporate Id
	 * @param  int    $projectId   Project Id
	 * @return mixed              
	 */
	public function upload($request, int $corporateId, int $projectId)
	{

		$columns = [
		   [ 'field' => 'label',
		   'title' => __('joesama/project::form.upload.label'),
		   'style' => 'text-left text-lowercase'],
		   [ 'field' => 'aging',
		   'title' => __('joesama/project::form.upload.aging'),
		   'style' => 'text-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::api/upload/download/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-download icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/upload/delete/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		$datagrid->buildTable($columns, __('joesama/project::manager.upload.list') )
				 ->buildDataModel(
				 	route('api.list.upload',[$corporateId, $projectId]), 
				 	$this->uploadObj->listUpload($corporateId, $projectId)
				 );

		return $datagrid->buildOption($action, TRUE)->render();
	}
} // END class MakeProjectProcessor 