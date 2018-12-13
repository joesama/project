<?php
namespace Joesama\Project\Http\Processors\Project; 

use Joesama\Project\Database\Repositories\Project\MakeProjectRepository;

/**
 * Make New Project Record 
 *
 * @package default
 * @author 
 **/
class MakeProjectProcessor 
{

	public function __construct(MakeProjectRepository $project)
	{
		$this->projectObj = $project;
	}

	/**
	 * New project
	 *
	 * @param Illuminate\Support\Collection  $projectData - name,contract,client,start,end
	 **/
	public function makeNewProject($projectData)
	{
		return $this->projectObj->initProject($projectData);
	}

	/**
	 * New Client
	 *
	 * @param Illuminate\Support\Collection $clientData - corporateid,name,phone,contact,manager,
	 **/
	public function makeNewClient($clientData)
	{
		return $this->projectObj->initClient($clientData);
	}

} // END class MakeProjectProcessor 