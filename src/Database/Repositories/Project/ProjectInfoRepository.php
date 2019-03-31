<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\{
	Project,
	Client,
	Task,
	Plan,
	Issue,
	Risk,
	Incident,
	ProjectPayment,
	ProjectVo,
	ProjectLad,
	ProjectRetention,
	ProjectUpload
};
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class ProjectInfoRepository 
{
	use HasAccessAs;

	private $projectModel, 
			$clientModel, 
			$taskModel, 
			$planModel, 
			$issueModel, 
			$riskModel, 
			$incidentModel, 
			$paymentModel, 
			$voModel, 
			$retentionModel, 
			$ladModel,
			$stricAccess,
			$uploadModel,
			$profile;

	public function __construct(
		Project $project , 
		Client $client,
		Task $task,
		Plan $plan,
		Issue $issue,
		Risk $risk,
		Incident $incident,
		ProjectPayment $payment,
		ProjectVo $vo,
		ProjectRetention $retention,
		ProjectLad $lad,
		ProjectUpload $upload
	){
		$this->projectModel = $project;
		$this->clientModel = $client;
		$this->taskModel = $task;
		$this->planModel = $plan;
		$this->issueModel = $issue;
		$this->riskModel = $risk;
		$this->incidentModel = $incident;
		$this->paymentModel = $payment;
		$this->voModel = $vo;
		$this->retentionModel = $retention;
		$this->ladModel = $lad;
		$this->uploadModel = $upload;
		$this->stricAccess = true;
		$this->profile = $this->profile();
	}

	/**
	 * Retrieve Project Record
	 *
	 * @param 	int 	$projectId 	id for specific project
	 * @param  	int    	$reportId  	Report Id
	 * 
	 * @return Joesama\Project\Database\Model\Project\Project
	 */
	public function getProject(int $projectId, string $type = 'all')
	{
		return $this->projectModel
				->component($type)
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
		$currentProfile = $this->profile->id;

		$project = $this->projectModel->active()
					->orderBy('updated_at','desc')
					->whereHas('profile',function($query) use($currentProfile){
						$query->where('profile_id',$currentProfile);
					});

		return $project->forListing()->paginate();
	}

	/**
	 * List of all project
	 *
	 * @return Illuminate\Support\Collection
	 **/
	public function projectAll()
	{
		return $this->projectModel->component()->get();
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
	 * Get Project Plan for specific Id
	 * 
	 * @param int $projectId
	 **/
	public function projectPlan(int $taskId)
	{
		return $this->planModel->find($taskId);
	}

	/**
	 * List of Task Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int | NULL $projectId
	 **/
	public function listProjectTask(int $corporateId, $projectId = null)
	{
		$task = $this->taskModel->whereHas('project',function($query) use($corporateId, $projectId){
			// $query->sameGroup($corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})
		->where(function($query){
			$query->whereHas('project',function($query){
				$query->whereHas('manager',function($query){
					$query->where('profile_id',$this->profile->id);
				})
				->orWhereHas('profile',function($query){
					$query->where('profile_id',$this->profile->id);
				});
			})
			->orWhere('profile_id',$this->profile->id);
		})
        ->whereNull('is_plan');

		return $task->component()->paginate();
	}
        
        /**
	 * List of Task Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int | NULL $projectId
	 **/
	public function listProjectPlan(int $corporateId, $projectId = null)
	{
		$task = $this->planModel->whereHas('project',function($query) use($corporateId, $projectId){
			// $query->sameGroup($corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})
		->where(function($query){
			$query->whereHas('project',function($query){
				$query->whereHas('manager',function($query){
					$query->where('profile_id',$this->profile->id);
				})
				->orWhereHas('profile',function($query){
					$query->where('profile_id',$this->profile->id);
				});
			})
			->orWhere('profile_id',$this->profile->id);
		});

		return $task->paginate();
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
		$issue = $this->issueModel->whereHas('project',function($query) use($corporateId, $projectId){
			// $query->sameGroup($corporateId);
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->where(function($query){
			$query->whereHas('project',function($query){
				$query->whereHas('manager',function($query){
					$query->where('profile_id',$this->profile->id);
				})
				->orWhereHas('profile',function($query){
					$query->where('profile_id',$this->profile->id);
				});
			})
			->orWhere('profile_id',$this->profile->id);
		});

		return $issue->component()->paginate();
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
	 * List of Partner Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectPartner(int $corporateId, $projectId)
	{

		$project = $this->getProject($projectId);
		$partner = data_get($project,'partner');

		return new LengthAwarePaginator(
			$partner,
			$partner->count(),
			20
		);

	}

	/**
	 * List of Attribute Under Corporate, Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectAttribute(int $corporateId, $projectId)
	{

		$project = $this->getProject($projectId);
		$attribute = data_get($project,'attributes');

		return new LengthAwarePaginator(
			$attribute,
			$attribute->count(),
			20
		);

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
			// $query->sameGroup($corporateId);
			$query->whereHas('profile',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * List of Incident Project
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectIncident(int $corporateId, $projectId)
	{
		return $this->incidentModel->whereHas('project',function($query) use($corporateId, $projectId){
			// $query->sameGroup($corporateId);
			$query->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * List of Project Payment
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectPayment(int $corporateId, $projectId)
	{
		return $this->paymentModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->sameGroup($corporateId);
			$query->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * List of Project VO
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectVo(int $corporateId, $projectId)
	{
		return $this->voModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->sameGroup($corporateId);
			$query->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * List of Project Retention
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectRetention(int $corporateId, $projectId)
	{
		return $this->retentionModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->sameGroup($corporateId);
			$query->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

	/**
	 * List of Project LAD
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listProjectLad(int $corporateId, $projectId)
	{
		return $this->ladModel->whereHas('project',function($query) use($corporateId, $projectId){
			$query->sameGroup($corporateId);
			$query->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$query->when($projectId, function ($query, $projectId) {
                return $query->where('id', $projectId);
            });
		})->component()->paginate();
	}

} // END class MakeProjectRepository 