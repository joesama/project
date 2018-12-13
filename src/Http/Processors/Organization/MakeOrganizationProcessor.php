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

	

} // END class MakeProjectProcessor 