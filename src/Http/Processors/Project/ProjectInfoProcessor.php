<?php
namespace Joesama\Project\Http\Processors\Project; 

use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class ProjectInfoProcessor 
{

	public function __construct(
		ProjectInfoRepository $projectInfo
	){
		$this->projectObj = $projectInfo;
	}

	/**
	 * Get Project By Id.
	 *
	 * @param int $projectId - id for selected project
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function projectInfo(int $projectId)
	{
		return $this->projectObj->getProject($projectId);
	}

	/**
	 * Get Project By Corporate.
	 *
	 * @param int $corporateId - id for corporate
	 * @return Illuminate\Support\Collection
	 **/
	public function projectList(int $corporateId)
	{
		return $this->projectObj->projectList($projectId);
	}

	/**
	 * Get Client By Id.
	 *
	 * @param int $clientId - id for specific client
	 * @return Joesama\Project\Database\Model\Project\Client
	 **/
	public function clientInfo(int $clientId)
	{
		return $this->projectObj->getClient($clientId);
	}

	/**
	 * Get Client By Id.
	 *
	 * @param int $corporateId - id for corporate
	 * @return Illuminate\Support\Collection
	 **/
	public function clientList(int $corporateId)
	{
		return $this->projectObj->clientList($corporateId);
	}

} // END class MakeProjectProcessor 