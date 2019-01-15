<?php
namespace Joesama\Project\Http\Processors\Corporate; 

use Joesama\Project\Database\Repositories\Organization\OrganizationInfoRepository;
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
	private $organization, $project;

	/**
	 * Class constructor
	 * 
	 * @param OrganizationInfoRepository $organization 
	 */
	public function __construct(
		OrganizationInfoRepository $organization,
		ProjectInfoRepository $projectInfo
	)
	{
		$this->organization = $organization;
		$this->project = $projectInfo;
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function profile($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.profile.name'),
		   'style' => 'text-left text-capitalize'],
		   [ 'field' => 'email',
		   'title' => __('joesama/project::form.profile.email'),
		   'style' => 'text-left text-lowercase'],
		   [ 'field' => 'phone',
		   'title' => __('joesama/project::form.profile.phone'),
		   'style' => 'text-center']
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.view') , // Action Description
			    'url' => handles('joesama/project::corporate/profile/view/'.$corporateId), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::corporate/profile/form/'.$corporateId), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => __('joesama/project::form.action.assign') , // Action Description
			    'url' => handles('joesama/project::corporate/profile/assign/'.$corporateId), // URL for action
			    'icons' => 'psi-project icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::corporate.profile.list') )
				 ->buildDataModel(
				 	route('api.list.profile',$corporateId), 
				 	$this->organization->listProfile($corporateId)
				 )->buildAddButton(route('corporate.profile.form',$corporateId))
				 ->buildOption($action, TRUE)
				 ->render();
	}


	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return HTML
	 */
	public function client($request,$corporateId)
	{

		$columns = [
		   [ 'field' => 'name',
		   'title' => __('joesama/project::form.client.name'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'phone',
		   'title' => __('joesama/project::form.client.phone'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'manager',
		   'title' => __('joesama/project::form.client.manager'),
		   'style' => 'text-xs-left text-capitalize'],
		   [ 'field' => 'contact',
		   'title' => __('joesama/project::form.client.contact'),
		   'style' => 'text-xs-left text-capitalize'],
		];

		$action = [
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.view') , // Action Description
			    'url' => handles('joesama/project::corporate/client/view/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-magnifi-glass icon', // Icon for action : optional
			    'key' => 'id'  ],
			[ 'action' => trans('joesama/vuegrid::datagrid.buttons.edit') , // Action Description
			    'url' => handles('joesama/project::corporate/client/form/'.$corporateId.'/'.$request->segment(5)), // URL for action
			    'icons' => 'psi-file-edit icon', // Icon for action : optional
			    'key' => 'id'  ]
		];

		$datagrid = new DataGridGenerator();
		
		return $datagrid->buildTable($columns, __('joesama/project::corporate.client.list') )
				 ->buildDataModel(
				 	route('api.list.client',$corporateId), 
				 	$this->project->clientAll()
				 )->buildAddButton(route('corporate.client.form',[$corporateId,$request->segment(5)]))
				 ->buildOption($action, TRUE)
				 ->render();
	}

} // END class MakeProjectProcessor 