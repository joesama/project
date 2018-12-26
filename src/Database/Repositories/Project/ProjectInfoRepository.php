<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\{
	Project,
	Client,
	Task,
	Issue,
	Risk
};
use DB;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class ProjectInfoRepository 
{

	public function __construct(
		Project $project , 
		Client $client,
		Task $task,
		Issue $issue,
		Risk $risk
	){
		$this->projectModel = $project;
		$this->clientModel = $client;
		$this->taskModel = $task;
		$this->issueModel = $issue;
		$this->riskModel = $risk;
	}

	/**
	 * Retrieve Project Record
	 *
	 * @param int $projectId - id for specific project
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function getProject(int $projectId)
	{
		return $this->projectModel
		->component()
		->find($projectId);
	}

	/**
	 * List of project for corporate
	 *
	 * @param int $corporateId - id for specific corporate
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function projectList(int $corporateId)
	{
		return $this->projectModel->component()->where('corporate_id',$corporateId)->paginate();
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
		return $this->clientModel->paginate();
	}

	/**
	 * Get Project Task for specific Id
	 * 
	 * @param int $projectId
	 **/
	public function projectTask(int $taskId)
	{
		return $this->taskModel->find($taskId);
	}

	/**
	 * List of Task Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int | NULL $projectId
	 **/
	public function listProjectTask(int $corporateId, $projectId = null)
	{
		return $this->taskModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->where('corporate_id',$corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * Get Project Issue for specific Id
	 * 
	 * @param int $issueId
	 **/
	public function projectIssue(int $issueId)
	{
		return $this->issueModel->find($issueId);
	}

	/**
	 * List of Issue Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int | NULL $projectId
	 **/
	public function listProjectIssue(int $corporateId, $projectId = null)
	{
		return $this->issueModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->where('corporate_id',$corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * Get Project Risk for specific Id
	 * 
	 * @param int $riskId
	 **/
	public function projectRisk(int $riskId)
	{
		return $this->riskModel->find($issueId);
	}

	/**
	 * List of Risk Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int | NULL $projectId
	 **/
	public function listProjectRisk(int $corporateId, $projectId = null)
	{
		return $this->riskModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->where('corporate_id',$corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

} // END class MakeProjectRepository 