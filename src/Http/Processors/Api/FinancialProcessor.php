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
class FinancialProcessor 
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
	public function claim(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->makeProject->initClaim(collect($request->all()),$request->segment(6));

		return redirect(handles('manager/'.$request->segment(2).'/list/'.$corporateId.'/'.$project->id));
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function payment(Request $request,int $corporateId, int $projectId)
	{
		$payment = $this->makeProject->updateClaim(collect($request->all()),$request->segment(6));

		return redirect(handles('manager/project/view/'.$corporateId.'/'.$payment->project_id));
	}


} // END class MakeProjectProcessor 