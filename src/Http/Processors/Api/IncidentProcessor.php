<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MakeProjectRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class IncidentProcessor 
{

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MakeProjectRepository $makeProject
	){
		$this->projectObj = $projectInfo;
		$this->makeProject = $makeProject;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId, int $projectId)
	{
		$this->makeProject->initIncident(collect($request->all()),$request->segment(6));

		return redirect_with_message(handles('manager/hse/list/'.$corporateId.'/'.$projectId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.hse.form')
			]),
            'success'
		);
	}

	/**
	 * Remove issue data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteIncident($corporateId,$projectId,$request->segment(6));
	}

} // END class MakeProjectProcessor 