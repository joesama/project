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
class TaskProcessor 
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
	public function save(Request $request,int $corporateId, int $projectId = null)
	{
		$task = $this->makeProject->initTask(collect($request->all()),$request->segment(6));

        return redirect_with_message(
        handles('manager/task/list/'.$corporateId.'/'.$task->project_id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.view')
			]),
            'success'
		);
	}

	/**
	 * Remove task data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteTask($corporateId,$projectId,$request->segment(6));
	}
} // END class MakeProjectProcessor 