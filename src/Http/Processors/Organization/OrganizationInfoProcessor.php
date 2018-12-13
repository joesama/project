<?php
namespace Joesama\Project\Http\Processors\Organization; 


use Joesama\Project\Database\Repositories\Organization\OrganizationInfoRepository;

/**
 * Retrieve Organization Record 
 *
 * @package default
 * @author 
 **/
class OrganizationInfoProcessor 
{

	public function __construct(OrganizationInfoRepository $organization)
	{
		$this->organizationObj = $organization;
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

	

} // END class MakeProjectProcessor 