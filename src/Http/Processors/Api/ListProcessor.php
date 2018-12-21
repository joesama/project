<?php
namespace Joesama\Project\Http\Processors\Api; 

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

	public function __construct(
		ProjectInfoRepository $projectInfo
	){
		$this->projectObj = $projectInfo;
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function project($request,$corporateId)
	{
		return $this->projectObj->projectList($corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function task($request,$corporateId)
	{
		return $this->projectObj->listProjectTask($corporateId, $request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function issue($request,$corporateId)
	{
		return $this->projectObj->listProjectIssue($corporateId, $request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function risk($request,$corporateId)
	{
		return $this->projectObj->listProjectRisk($corporateId, $request->segment(5));
	}
} // END class MakeProjectProcessor 