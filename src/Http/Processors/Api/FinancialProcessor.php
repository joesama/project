<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\FinancialRepository;
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
		MakeProjectRepository $makeProject,
		FinancialRepository $financeObj
	){
		$this->projectObj = $projectInfo;
		$this->financeObj = $financeObj;
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

		return redirect_with_message(
			handles('manager/'.$request->segment(2).'/list/'.$corporateId.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.form')
			]),
            'success'
		);
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

		return redirect_with_message(
			handles('manager/'.$request->segment(2).'/list/'.$corporateId.'/'.$projectId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.form')
			]),
            'success'
		);
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

		return redirect_with_message(handles('manager/financial/vo/'.$corporateId.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.financial.voform')
			]),
            'success'
		);
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

		return redirect_with_message(
			handles('manager/financial/retention/'.$corporateId.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.financial.retentionform')
			]),
            'success'
		);
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

		return redirect_with_message(
			handles('manager/financial/lad/'.$corporateId.'/'.$project->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.financial.ladform')
			]),
            'success'
		);
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

	/**
	 * Remove lad data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function scurve(Request $request,int $corporateId, int $projectId)
	{
		return $this->financeObj->schedulePayment($corporateId,$projectId);
	}

} // END class MakeProjectProcessor 