<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
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
	public function projectApprovalList($request, int $corporateId)
	{
		$isHistory = ($request->segment(2) == 'project' || $request->segment(3) == 'approval-project') ? true : false;

		return ProjectApproval::where(function($query) use($isHistory){
					$query->when($isHistory, function ($query, $isHistory) { 
						return $query->whereHas('project',function($query){
							$query->whereHas('manager',function($query){
								$query->where('profile_id',$this->profile()->id);
							});
							$query->orWhereHas('profile',function($query){
								$query->where('profile_id',$this->profile()->id);
							});
						});
					});
					$query->orWhere('need_action',$this->profile()->id);
				})
				->orderBy('updated_at','desc')
				->component()
				->paginate();
	}


	/**
	 * Register New Project For Approval
	 * 
	 * @param  Project $project  Created Project Model
	 * @param          $workflow Assigned Workflow
	 * @return [type]            [description]
	 */
	public function registerProject(Project $project, $workflow)
	{
		$currentProfile = $this->profile();

		$initialAction = $workflow->get('first');

		$nextAction = $workflow->get('next');

		try{
			$approval = ProjectApproval::firstOrNew([
				'project_id' =>  $project->id
			]);

			$state = strtolower(data_get($initialAction,'status'));

			$approval->workflow_id = data_get($initialAction,'status_id');

			$approval->creator_id = $currentProfile->id;

			$approval->need_action = data_get($nextAction,'profile_assign.id');

			$approval->need_step = data_get($nextAction,'id');

			$approval->state = $state;
			
			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $project->scope,
				'state' => $state ,
				'step_id' => data_get($initialAction,'id') ,
				'profile_id' => data_get($initialAction,'profile_assign.id'),
			]);

			$approval->workflow()->save($workflow);

			if(!is_null($approval->nextby)){
				$project->profile->each(function($profile) use($project,$approval,$state){
					$profile->sendActionNotification($project,$approval,$state );
				});

			}else{
				$approval->creator->sendAcceptedNotification($project,$approval,$state );
			}

			DB::commit();

		}catch( \Exception $e){
			DB::rollback();

			throw new \Exception($e->getMessage(), 1);
		}
	}

	/**
	 * Update Approval Workflow
	 * 
	 * @param  Project $projectId 	Project Object
	 * @param  Request $request 	Form Input
	 * @return Joesama\Project\Database\Model\Project\Project
	 */
	public function processApproval(int $projectId, Request $request): Project
	{
		try{
			$project = Project::with('approval.workflow')->find($projectId);

			$project->active = ( is_null($request->get('need_step')) &&  $request->get('state') !== 'closed') ? 1 : 0;

			$approval = $project->approval;

			$approval->workflow_id = $request->get('status');

			if($request->get('state') == 5){
				$approval->approved_by = $this->profile()->id;

				$approval->approve_date = Carbon::now();
			}

			$approval->need_action = $request->get('need_action');

			$approval->need_step = $request->get('need_step');

			$approval->state = $request->get('state');

			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $request->get('remark'),
				'state' => $request->get('state'),
				'step_id' => $request->get('current_step'),
				'profile_id' => $request->get('current_action'),
			]);

			$approval->workflow()->save($workflow);

			$project->save();

			if(!is_null($approval->nextby)){
				$project->profile->groupBy('id')->each(function($profile)  use($project,$approval,$request){
					$profile->first()->sendActionNotification($project,$approval,$request->get('type'), 'warning');
				});
			}else{
				$approval->creator->sendActionNotification($project,$approval,$request->get('type'));
			}

			DB::commit();

			return $project;

		}catch( \Exception $e){
			DB::rollback();

			throw new \Exception($e->getMessage(), 1);
		}
	}
} // END class ProjectWorkflowRepository 