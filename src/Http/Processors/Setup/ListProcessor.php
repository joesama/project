<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Setup\MasterDataRepository;
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

	public function __construct(
		MasterDataRepository $masterData,
		ProjectInfoRepository $project
	){
		$this->masterDataObj = $masterData;
		$this->projectObj = $project;
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

} // END class MakeProjectProcessor 