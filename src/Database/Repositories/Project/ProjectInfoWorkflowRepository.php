<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\ProjectInfo;
use Joesama\Project\Database\Model\Project\ProjectInfoWorkflow;
use Joesama\Project\Traits\HasAccessAs;

class ProjectInfoWorkflowRepository 
{	
	use HasAccessAs;

	/**
	 * Project Info Snippet
	 *
	 * @return void
	 * @author 
	 **/
	public function projectInfo($id)
	{
		return ProjectInfo::component()->find($id);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function registerInfoWorkflow(ProjectInfo $projectInfo)
	{

		$pmoHead = $projectInfo->project->profile->where('corporate_id','!=',$projectInfo->project->corporate_id)->where('pivot.role_id',3)->first();

		$flow = collect(config('joesama/project::workflow.approval'));
		$initialFlow = $flow->keys()->first();
		$nextAction = $flow->keys()->slice(1,1)->first();

		$state = strtolower(MasterData::find($initialFlow)->description);
		
		$projectInfo->is_process = 1;
		$projectInfo->creator_id = $this->profile()->id;
		$projectInfo->workflow_id = $initialFlow;
		$projectInfo->need_action = $pmoHead->id;
		$projectInfo->need_step = $nextAction;
		$projectInfo->state = $state;
		$projectInfo->save();

		$workflow = new ProjectInfoWorkflow([
			'remark' => 'Changes Project Information',
			'state' => $state ,
			'profile_id' => $this->profile()->id,
		]);

		$projectInfo->workflow()->save($workflow);

		if($projectInfo->nextby != null){
			// $projectInfo->nextby->sendActionNotification($projectInfo->project, $projectInfo, 'info');
			$project->profile->each(function($profile) use($projectInfo){
				$profile->sendActionNotification($projectInfo->project, $projectInfo, 'info');
			});
		}else{
			$projectInfo->creator->sendAcceptedNotification($projectInfo->project, $projectInfo, 'info');
		}

	}

	/**
	 * Register New Project For Approval
	 * @param  Project $project Project Object
	 * @param  Request $project Project Object
	 * @return [type]           [description]
	 */
	public function processInfo(ProjectInfo $projectInfo, Request $request)
	{
		DB::beginTransaction();

		try{

			$projectInfo->workflow_id = $request->get('state');

			if($request->get('state') == 5){
				$projectInfo->is_approve = 1;
				$projectInfo->approved_by = $this->profile()->id;
				$projectInfo->approve_date = Carbon::now();
			}

			$projectInfo->creator_id = $this->profile()->id;
			$projectInfo->need_action = $request->get('need_action');
			$projectInfo->need_step = $request->get('need_step');
			$projectInfo->state = $request->get('status');
			$projectInfo->save();

			$workflow = new ProjectInfoWorkflow([
				'remark' => $request->get('remark'),
				'state' => $request->get('status'),
				'profile_id' => $this->profile()->id,
			]);

			$projectInfo->workflow()->save($workflow);

			if($request->get('state') == 5){
				$this->approvedChanges($projectInfo, $projectInfo->project);
			}

			if(!is_null($projectInfo->nextby)){
				// $projectInfo->nextby->sendActionNotification($projectInfo->project,$projectInfo,'info');
				$project->profile->each(function($profile) use($projectInfo){
					$profile->sendActionNotification($projectInfo->project, $projectInfo, 'info');
				});
			}else{
				$projectInfo->creator->sendAcceptedNotification($projectInfo->project,$projectInfo,'info');
			}

			DB::commit();

		}catch( \Exception $e){
			throw new \Exception($e->getMessage(), 1);
			DB::rollback();
		}
	}

	/**
	 * Change Current info to latest info
	 * @param  [type] $infoProject [description]
	 * @param  [type] $project     [description]
	 * @return [type]              [description]
	 */
	public function approvedChanges($infoProject, $project)
	{
		$project->name = $infoProject->name; 

		$project->value = $infoProject->value; 

		$project->contract = $infoProject->contract; 

		$project->gp_propose = $infoProject->gp_propose;

		$project->job_code = $infoProject->job_code;

		$project->gp_latest = $infoProject->gp_latest;

		$project->bond = $infoProject->bond;

		$project->scope = $infoProject->scope;

		$project->start = $infoProject->start;

		$project->end = $infoProject->end;

		$project->save();
	}

	/**
	 * Monthly Report Workflow
	 * 
	 * @param  int    	$corporateId 	Corporate Id
	 * @param  Project  $project   		Project Model
	 * @return Collection
	 */
	public function infoWorkflow(int $corporateId, $projectInfo)
	{
		return collect(config('joesama/project::workflow.approval'))->map(function($role,$state) use($corporateId,$projectInfo){

			$status = strtolower(MasterData::find($state)->description);

			if (in_array($state,[1,2])) {
				$profile = $projectInfo->project->profile->where('corporate_id',$projectInfo->project->corporate_id)->where('pivot.role_id',$role)->first();
			} else {
				$profile = $projectInfo->project->profile->where('corporate_id',1)->where('pivot.role_id',$role)->first();
			}

			return [
				'status' => $status,
				'step' => $state,
				'infoCard' => $projectInfo,
				'profile' => $profile
			];
		});
	}

} // END class ProjectInfoWorkflowRepository 