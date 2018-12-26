<?php
namespace Joesama\Project\Http\Processors\Api; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Setup\MasterDataRepository;
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
		ProjectInfoRepository $projectInfo,
		MasterDataRepository $masterData
	){
		$this->projectObj = $projectInfo;
		$this->masterDataObj = $masterData;
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

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function master($request,$corporateId)
	{
		return $this->masterDataObj->listMaster($corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function data($request,$corporateId)
	{
		return $this->masterDataObj->listData($corporateId,$request->segment(5));
	}
} // END class MakeProjectProcessor 