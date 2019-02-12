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
class ProjectProcessor 
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
	public function save(Request $request,int $corporateId)
	{
		$project = $this->makeProject->initProject(collect($request->all()),$request->segment(5));

		return redirect_with_message(
			handles('manager/'.$request->segment(2).'/view/'.$corporateId.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.project')
			]),
            'success'
		);
	}


} // END class MakeProjectProcessor 