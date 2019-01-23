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
	 * Remove claim data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteClaim($corporateId,$projectId,$request->segment(6));
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

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function vo(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->makeProject->initVo(collect($request->all()),$request->segment(6));

		return redirect(handles('manager/financial/vo/'.$corporateId.'/'.$project->id));
	}

	/**
	 * Remove vo data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function vodelete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteVo($corporateId,$projectId,$request->segment(6));
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function retention(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->makeProject->initRetention(collect($request->all()),$request->segment(6));

		return redirect(handles('manager/financial/retention/'.$corporateId.'/'.$project->id));
	}

	/**
	 * Remove retention data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function retentiondelete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteRetention($corporateId,$projectId,$request->segment(6));
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function lad(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->makeProject->initLad(collect($request->all()),$request->segment(6));

		return redirect(handles('manager/financial/lad/'.$corporateId.'/'.$project->id));
	}

	/**
	 * Remove lad data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function laddelete(Request $request,int $corporateId, int $projectId)
	{
		return $this->makeProject->deleteLad($corporateId,$projectId,$request->segment(6));
	}


} // END class MakeProjectProcessor 