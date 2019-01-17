<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\ProjectApproval;
use Joesama\Project\Database\Model\Project\ProjectApprovalWorkflow;


class ProjectWorkflowRepository 
{	

	/**
	 * List of project for corporate
	 *
	 * @param int $corporateId - id for specific corporate
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function projectApprovalList(int $corporateId)
	{

		$project = $this->projectModel->sameGroup($corporateId);

		if($this->stricAccess){
			$project->whereHas('manager',function($query){
				$query->where('profile_id',$this->profile->id);
			});
			$project->orWhereHas('admin',function($query){
				$query->where('profile_id',$this->profile->id);
			});
		}

		return $project->component()->paginate();
	}


	/**
	 * Register New Project For Approval
	 * @param  Project $project Project Object
	 * @return [type]           [description]
	 */
	public function registerProject(Project $project)
	{

		$projectManager = $project->profile->where('pivot.role_id',2)->first();
		$pmoOfficer = $project->profile->where('corporate_id','!=',$project->corporate_id)->where('pivot.role_id',5)->first();
		$pmoHead = $project->profile->where('corporate_id','!=',$project->corporate_id)->where('pivot.role_id',3)->first();
		$pmoCoo = $project->profile->where('corporate_id','!=',$project->corporate_id)->where('pivot.role_id',4)->first();

		$initialFlow = collect(config('joesama/project::workflow.approval'))->keys()->first();

		try{

			$approval = ProjectApproval::firstOrNew([
				'project_id' =>  $project->id
			]);

			$approval->workflow_id = $initialFlow;
			$approval->creator_id = $projectManager->id;
			$approval->need_action = $pmoOfficer->id;
			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $project->scope,
				'state' => strtolower(MasterData::find($initialFlow)->description),
				'profile_id' => $projectManager->id,
			]);

			DB::commit();

			$approval->workflow()->save($workflow);

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Project Approval Workflow
	 * 
	 * @param  int    	$corporateId 	Corporate Id
	 * @param  int    	$projectId   	Project Id
	 * @param  string   $dateStart   	Report Date Start
	 * @param  string   $dateEnd   		Report Date End
	 * @return Collection
	 */
	public function projectWorkflow(int $corporateId, int $projectId)
	{
		return collect(config('joesama/project::workflow.0'))->map(function($role,$state) use($corporateId,$projectId){
			dump($state);

		});
	}


} // END class ProjectWorkflowRepository 