<?php
namespace Joesama\Project\Http\Processors\Organization; 


use Joesama\Project\Database\Repositories\Organization\OrganizationInfoRepository;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Retrieve Organization Record 
 *
 * @package default
 * @author 
 **/
class OrganizationInfoProcessor 
{
	use HasAccessAs;
	
	public function __construct(OrganizationInfoRepository $organization)
	{
		$this->organizationObj = $organization;
		$this->profile();
	}

	/**
	 * Corporate Info
	 *
	 * @param $corporateId - id for selected corporate
	 **/
	public function corporateInfo(int $corporateId)
	{
		return $this->organizationObj->getCorporate($corporateId);
	}

	/**
	 * List Of Corporate
	 *
	 **/
	public function corporateList()
	{
		return $this->organizationObj->listCorporate();
	}

	/**
	 * Profile Info
	 *
	 * @param $profileId - id for selected corporate
	 **/
	public function profileInfo(int $profileId)
	{
		return $this->organizationObj->getProfile($profileId);
	}

	/**
	 * List Of Profile Under Corporate
	 *
	 * @param int $corporateId
	 **/
	public function profileList(int $corporateId)
	{
		return $this->organizationObj->listProfile($corporateId);
	}

	/**
	 * List Of Profile Under Project
	 *
	 * @param int $corporateId
	 **/
	public function projectProfileList(int $projectId)
	{
		return $this->organizationObj->listProjectProfile($projectId);
	}

	

} // END class MakeProjectProcessor 