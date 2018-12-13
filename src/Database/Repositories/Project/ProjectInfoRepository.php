<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Client;
use DB;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class ProjectInfoRepository 
{

	public function __construct(Project $project , Client $client)
	{
		$this->projectModel = $project;
		$this->clientModel = $client;
	}

	/**
	 * Retrieve Project Record
	 *
	 * @param int $projectId - id for specific project
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function getProject(int $projectId)
	{
		return $this->projectModel->find($projectId);
	}

	/**
	 * List of project for corporate
	 *
	 * @param int $corporateId - id for specific corporate
	 * @return Illuminate\Support\Collection
	 **/
	public function projectList(int $corporateId)
	{
		return $this->projectModel->where('corporate_id',$corporateId)->get();
	}

	/**
	 * List of all project
	 *
	 * @return Illuminate\Support\Collection
	 **/
	public function projectAll()
	{
		return $this->projectModel->get();
	}

	/**
	 * Retrieve Client Record
	 *
	 * @param int $clientId - id for specific client
	 * @return Joesama\Project\Database\Model\Project\Client
	 **/
	public function getClient(int $clientId)
	{
		return $this->clientModel->find($projectId);
	}

	/**
	 * List of client for corporate
	 *
	 * @param int $corporateId - id for specific corporate
	 * @return Illuminate\Support\Collection
	 **/
	public function clientList(int $corporateId)
	{
		return $this->clientModel->where('corporate_id',$corporateId)->get();
	}

	/**
	 * List of all client
	 *
	 * @return Illuminate\Support\Collection
	 **/
	public function clientAll()
	{
		return $this->clientModel->get();
	}


} // END class MakeProjectRepository 