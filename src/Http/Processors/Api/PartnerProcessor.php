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
class PartnerProcessor 
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
		$project = $this->makeProject->initPartner(collect($request->all()),$request->segment(5));

		return redirect_with_message(
			handles('manager/project/view/'.$project->corporate_id.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.partner.view')
			]),
            'success'
		);

	}

	/**
	 * Remove partner data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		$this->makeProject->deletePartner($corporateId,$projectId,$request->segment(6));

		return redirect(handles('manager/project/view/'.$corporateId.'/'.$projectId));
	}


} // END class MakeProjectProcessor 