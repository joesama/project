<?php
namespace Joesama\Project\Database\Repositories\Organization; 

use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use DB;

/**
 * Data Handling For Organization Record
 *
 * @package default
 * @author 
 **/
class OrganizationInfoRepository 
{

	public function __construct(
		Corporate $model,
		Profile $profile
	){
		$this->corporatetModel = $model;
		$this->profileModel = $profile;
	}

	/**
	 * Corporate Record By Id
	 *
	 * @param int $corporateId
	 **/
	public function getCorporate(int $corporateId)
	{
		return $this->corporatetModel->find($corporateId);
	}

	/**
	 * List of Corporate
	 **/
	public function listCorporate()
	{
		return $this->corporatetModel->whereNull('child_to')->get();
	}
	/**
	 * Profile Record By Id
	 *
	 * @param int $profileId
	 **/
	public function getProfile(int $profileId)
	{
		return $this->profileModel->find($profileId);
	}

	/**
	 * List of Profile Under Corporate
	 * 
	 * @param int $corporateId
	 **/
	public function listProfile(int $corporateId)
	{
		return $this->profileModel->where('corporate_id',$corporateId)->get();
	}

	/**
	 * List of Profile Under Project
	 * 
	 * @param int $projectId
	 **/
	public function listProjectProfile(int $projectId)
	{
		return $this->profileModel->whereHas('project',function($query) use($projectId){
			$query->where('id',$projectId);
		})->get();
	}


} // END class MakeProjectRepository 