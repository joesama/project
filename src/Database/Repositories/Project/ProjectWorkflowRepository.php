<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\ProjectApproval;
use Joesama\Project\Database\Model\Project\ProjectApprovalWorkflow;
use Joesama\Project\Traits\HasAccessAs;


class ProjectWorkflowRepository 
{	
	use HasAccessAs;

	/**
	 * List of project for corporate
	 *
	 * @param int $corporateId - id for specific corporate
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function projectApprovalList(int $corporateId)
	{
		return ProjectApproval::where(function($query) {
					$query->whereHas('project',function($query) {
						$query->whereHas('manager',function($query){
							$query->where('profile_id',$this->profile()->id);
						});
					});
					$query->orWhere('need_action',$this->profile()->id);
				})
				->component()
				->paginate();
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
			throw new Exception($e->getMessage(), 1);
			DB::rollback();
		}
	}

	/**
	 * Register New Project For Approval
	 * @param  Project $project Project Object
	 * @param  Request $project Project Object
	 * @return [type]           [description]
	 */
	public function approveProject(Project $project, Request $request)
	{

		try{

			$project->active = 1;
			$project->save();

			$approval = ProjectApproval::firstOrNew([
				'project_id' =>  $project->id
			]);

			$approval->workflow_id = $request->get('state');
			$approval->creator_id = $this->profile()->id;
			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $request->get('remark'),
				'state' => $request->get('state'),
				'profile_id' => $this->profile()->id,
			]);

			$approval->workflow()->save($workflow);

			DB::commit();

		}catch( \Exception $e){
			throw new \Exception($e->getMessage(), 1);
			DB::rollback();
		}
	}

	/**
	 * Project Approval Workflow
	 * 
	 * @param  int    	$projectId   	Project Id
	 * @param       	$approval   	Project Approval Record
	 * @return Collection
	 */
	public function projectWorkflow(Collection $profile, $approval)
	{
		return collect(config('joesama/project::workflow.approval'))->map(function($role,$state) use($profile,$approval){

			$status = strtolower(MasterData::find($state)->description);

			$assignee = $profile->where('pivot.role_id',$role)->first();

			$workflow = $approval->workflow;

			return [
				'status' => $status,
				'approval' => $workflow->where('state',$status)->first(),
				'profile' => $assignee
			];
		});
	}


} // END class ProjectWorkflowRepository 