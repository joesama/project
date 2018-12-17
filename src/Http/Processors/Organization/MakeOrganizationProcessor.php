<?php
namespace Joesama\Project\Http\Processors\Organization; 


use Joesama\Project\Database\Repositories\Organization\MakeOrganizationRepository;

/**
 * Make New Organization Record 
 *
 * @package default
 * @author 
 **/
class MakeOrganizationProcessor 
{

	public function __construct(MakeOrganizationRepository $organization)
	{
		$this->organizationObj = $organization;
	}

	/**
	 * New Corporate Info
	 *
	 * @param $projectData - name,contract,client,start,end
	 **/
	public function makeNewCorporate($corporateData)
	{
		return $this->organizationObj->initCorporate($corporateData);
	}

	/**
	 * New Profile Info
	 *
	 * @param $profileData - corporate_id,name,abbr,email,phone
	 **/
	public function makeNewProfile($profileData)
	{
		return $this->organizationObj->initProfile($profileData);
	}

	/**
	 * New Profile Role Info
	 *
	 * @param $roleData - role
	 **/
	public function makeNewRole($roleData)
	{
		return $this->organizationObj->initRole($roleData);
	}

	

} // END class MakeProjectProcessor 