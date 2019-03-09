<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Setup\MasterDataRepository;
use Joesama\Project\Database\Repositories\Setup\ProcessRepository;
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

	/**
	 * Process Repository Class
	 * @var Joesama\Project\Database\Repositories\Setup\ProcessRepository
	 */
	private $processRepository;

	public function __construct(
		MasterDataRepository $masterData,
		ProjectInfoRepository $project,
		ProcessRepository $process
	){
		$this->masterDataObj = $masterData;
		$this->projectObj = $project;
		$this->processRepository = $process;
		$this->profile();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function master($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'description',
		   'title' => __('joesama/project::setup.master.form'),
		   'style' => 'text-xs-left text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::setup/master/view/'.$corporateId), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => handles('joesama/project::setup/master/form/'.$corporateId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::setup.master.list') )
				 ->buildDataModel(
				 	route('api.list.master',$corporateId,$request->segment(5)), 
				 	$this->masterDataObj->listMaster($corporateId,$request->segment(5))
				 )->buildAddButton(route('setup.master.form',$corporateId))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function data($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'description',
		   'title' => __('joesama/project::setup.master.form'),
		   'style' => 'text-xs-left text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::setup/data/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('product.item.variant') , // Action Description
			    'url' => handles('joesama/project::setup/data/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::setup.data.list') )
				 ->buildDataModel(
				 	route('api.list.data',[$corporateId,$request->segment(5)]), 
				 	$this->masterDataObj->listData($corporateId,$request->segment(5))
				 )->buildAddButton(route('setup.data.form',[$corporateId,$request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function flow($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'label',
		   'title' => __('joesama/project::form.process_flow.label'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'plain_description',
		   'title' => __('joesama/project::form.process_flow.description'),
		   'style' => 'text-xs-left text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::setup/flow/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('joesama/project::setup.step.view') , // Action Description
			    'url' => handles('joesama/project::setup/step/list/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-repeat-4 icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/flow/delete/'.$corporateId), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::setup.flow.list') )
				 ->buildDataModel(
				 	route('api.list.flow',[$corporateId]), 
				 	$this->processRepository->getAllFlowByCorporation($corporateId)
				 )->buildAddButton(route('setup.flow.form',[$corporateId,$request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function step($request, int $corporateId, int $flowId)
	{

		$columns = [
		   [ 'field' => 'label',
		   'title' => __('joesama/project::form.process_step.label'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'plain_description',
		   'title' => __('joesama/project::form.process_step.description'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'role.role',
		   'title' => __('joesama/project::form.process_step.role_id'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'status.description',
		   'title' => __('joesama/project::form.process_step.status_id'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'order',
		   'title' => __('joesama/project::form.process_step.order'),
		   'style' => 'text-center text-bold text-danger col-md-1 text-capitalize']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::setup/step/form/'.$corporateId.'/'.$flowId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'delete' => trans('joesama/vuegrid::datagrid.buttons.delete') , // Action Description
			    'url' => handles('joesama/project::api/step/delete/'.$corporateId.'/'.$flowId), // URL for action
			    'icons' => 'fa fa-remove icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::setup.step.list') )
				 ->buildDataModel(
				 	route('api.list.step',[$corporateId,$flowId]), 
				 	$this->processRepository->getFlowSteps($flowId)
				 )->buildAddButton(route('setup.step.form',[$corporateId,$flowId,$request->segment(6)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

} // END class MakeProjectProcessor 