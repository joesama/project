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

class ProjectUpdateWorkflowRepository
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
     * Register New Project Information Update Workflow
     *
     * @param  ProjectInfo $projectInfo    Project Information Model
     * @param  [type]      $updateWorkflow Update information workflow
     * @return [type]                      [description]
     */
    public function registerInfoWorkflow(ProjectInfo $projectInfo, $updateWorkflow)
    {
        $currentProfile = $this->profile();

        $initialAction = $updateWorkflow->get('first');

        $nextAction = $updateWorkflow->get('next');

        $state = strtolower(data_get($initialAction, 'status'));
        
        $projectInfo->is_process = 1;

        $state = strtolower(data_get($initialAction, 'status'));

        $projectInfo->workflow_id = data_get($initialAction, 'status_id');

        $projectInfo->creator_id = $currentProfile->id;

        $projectInfo->need_action = data_get($nextAction, 'profile_assign.id');

        $projectInfo->need_step = data_get($nextAction, 'id');

        $projectInfo->state = $state;

        $projectInfo->save();

        $workflow = new ProjectInfoWorkflow([
            'remark' => 'Changes Project Information',
            'state' => $state ,
            'step_id' => data_get($initialAction, 'id') ,
            'profile_id' => data_get($initialAction, 'profile_assign.id')
        ]);

        $projectInfo->workflow()->save($workflow);

        if ($projectInfo->nextby != null) {
            $projectInfo->nextby->sendActionNotification(
                $projectInfo->project,
                $projectInfo,
                $updateWorkflow->get('type'),
                'warning'
            );
        }
    }

    /**
     * Update Process Flow For Update Information
     * 
     * @param  int     $projectInfoId Current Project Information Update
     * @param  Request $request       Http Input Request
     * @return [type]                 [description]
     */
    public function processInfo(int $projectInfoId, Request $request)
    {
        $projectInfo = $this->projectInfo($projectInfoId);

        $type = $request->get('type');

        DB::beginTransaction();

        try {
            $projectInfo->workflow_id = $request->get('status_id');

            if ( is_null($request->get('need_step')) &&  $request->get('state') !== 'closed' ) {
                $projectInfo->is_approve = 1;

                $projectInfo->approved_by = $request->get('current_action');

                $projectInfo->approve_date = Carbon::now();
            }

            $projectInfo->need_action = $request->get('need_action');

            $projectInfo->need_step = $request->get('need_step');

            $projectInfo->state = $request->get('state');

            $projectInfo->save();

            $workflow = new ProjectInfoWorkflow([
                'remark' => $request->get('remark'),
                'state' => $request->get('state'),
                'step_id' => $request->get('current_step'),
                'profile_id' => $request->get('current_action'),
            ]);

            $projectInfo->workflow()->save($workflow);

            if (is_null($request->get('need_step'))) {
                $this->approvedChanges($projectInfo, $projectInfo->project);
            }

            if (!is_null($projectInfo->nextby)) {
                // $projectInfo->nextby->sendActionNotification($projectInfo->project,$projectInfo,'info');
                $projectInfo->project->profile->groupBy('id')->each(function ($profile) use ($projectInfo, $type) {
                    $profile->first()->sendActionNotification($projectInfo->project, $projectInfo, $type, 'warning');
                });
            } else {
                $projectInfo->creator->sendActionNotification($projectInfo->project, $projectInfo, $type, 'success');
            }

            DB::commit();

            return $projectInfo;

        } catch (\Exception $e) {
            DB::rollback();

            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * Change Current info to latest info
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
} // END class ProjectInfoWorkflowRepository
