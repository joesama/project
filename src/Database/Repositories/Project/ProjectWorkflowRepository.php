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
		$nextAction = collect(config('joesama/project::workflow.approval'))->keys()->slice(1,1)->first();

		try{

			$approval = ProjectApproval::firstOrNew([
				'project_id' =>  $project->id
			]);

			$state = strtolower(MasterData::find($initialFlow)->description);

			$approval->workflow_id = $initialFlow;
			$approval->creator_id = $projectManager->id;
			$approval->need_action = $pmoHead->id;
			$approval->need_step = $nextAction;
			$approval->state = $state;
			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $project->scope,
				'state' => $state ,
				'profile_id' => $projectManager->id,
			]);

			$approval->workflow()->save($workflow);

			if(!is_null($approval->nextby)){
				// $approval->nextby->sendActionNotification($project,$approval,$state );
				$project->profile->each(function($profile) use($project,$approval,$state){
					$profile->sendActionNotification($project,$approval,$state );
				});

			}else{
				$approval->creator->sendAcceptedNotification($project,$approval,$state );
			}

			DB::commit();

		}catch( \Exception $e){
			throw new \Exception($e->getMessage(), 1);
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

			$project->active = is_null($request->get('need_step')) ? 1 : 0;
			$project->save();

			$approval = ProjectApproval::firstOrNew([
				'project_id' =>  $project->id
			]);

			$approval->workflow_id = $request->get('state');

			if($request->get('state') == 5){
				$approval->approved_by = $this->profile()->id;
				$approval->approve_date = Carbon::now();
			}

			$approval->creator_id = $this->profile()->id;
			$approval->need_action = $request->get('need_action');
			$approval->need_step = $request->get('need_step');
			$approval->state = $request->get('status');
			$approval->save();

			$workflow = new ProjectApprovalWorkflow([
				'remark' => $request->get('remark'),
				'state' => $request->get('status'),
				'profile_id' => $this->profile()->id,
			]);

			$approval->workflow()->save($workflow);

			if(!is_null($approval->nextby)){
				// $approval->nextby->sendActionNotification($project,$approval,$request->get('status'));
				$project->profile->each(function($profile)  use($project,$approval,$request){
					$profile->sendActionNotification($project,$approval,$request->get('status'));
				}); 
				
			}else{
				$approval->creator->sendAcceptedNotification($project,$approval,$request->get('status'));
			}

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

			$workflow = collect(data_get($approval,'workflow'))->where('state',$status);

			return [
				'status' => $status,
				'step' => $state,
				'approval' => $workflow->first(),
				'profile' => $assignee
			];
		});
	}


} // END class ProjectWorkflowRepository 