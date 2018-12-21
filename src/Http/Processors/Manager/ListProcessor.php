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
		   [ 'field' => 'in_charge.name',
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
			    'url' => handles('joesama/vuegrid::'), // URL for action
			    'icons' => 'psi-magnifi-glass icon-fw', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => url('product/list/variant'), // URL for action
			    'icons' => 'psi-file-edit icon-fw', // Icon for action : optional
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
		   'title' => __('joesama/project::project.task.task'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'in_charge.name',
		   'title' => 'PIC',
		   'style' => 'text-xs-center'],
		   [ 'field' => 'progress',
		   'title' => __('joesama/project::project.task.progress'),
		   'style' => 'text-xs-center'],
		   [ 'field' => 'start_date',
		   'title' => __('joesama/project::project.task.date.start'),
		   'style' => 'text-xs-center date hidden'],
		   [ 'field' => 'end_date',
		   'title' => __('joesama/project::project.task.date.end'),
		   'style' => 'text-xs-center date hidden']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/vuegrid::'), // URL for action
			    'icons' => 'psi-magnifi-glass icon-fw', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => url('product/list/variant'), // URL for action
			    'icons' => 'psi-file-edit icon-fw', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.task') )
				 ->buildDataModel(
				 	route('api.list.task',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectTask($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.issue.form',$corporateId))
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
		   [ 'field' => 'name',
		   'title' => __('joesama/project::project.issues.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'in_charge.name',
		   'title' => 'PIC',
		   'style' => 'text-xs-center'],
		   [ 'field' => 'progress.description',
		   'title' => __('joesama/project::project.issues.status'),
		   'style' => 'text-xs-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/vuegrid::'), // URL for action
			    'icons' => 'psi-magnifi-glass icon-fw', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => url('product/list/variant'), // URL for action
			    'icons' => 'psi-file-edit icon-fw', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.issue') )
				 ->buildDataModel(
				 	route('api.list.issue',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIssue($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.issue.form',$corporateId))
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
		   [ 'field' => 'name',
		   'title' => __('joesama/project::project.risk.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'in_charge.name',
		   'title' => 'PIC',
		   'style' => 'text-xs-center'],
		   [ 'field' => 'severity.description',
		   'title' => __('joesama/project::project.risk.severity'),
		   'style' => 'text-xs-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/vuegrid::'), // URL for action
			    'icons' => 'psi-magnifi-glass icon-fw', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => url('product/list/variant'), // URL for action
			    'icons' => 'psi-file-edit icon-fw', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::project.list.risk') )
				 ->buildDataModel(
				 	route('api.list.risk',[$corporateId, $request->segment(5)]), 
				 	$this->projectObj->listProjectIssue($corporateId, $request->segment(5))
				 )->buildAddButton(route('manager.risk.form',$corporateId))
				 ->buildOption($action, TRUE)
				 ->render();
	}
} // END class MakeProjectProcessor 