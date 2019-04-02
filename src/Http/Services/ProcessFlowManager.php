<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Process\Flow;
use Joesama\Project\Database\Model\Project\Project;

class ProcessFlowManager
{
    const APPROVAL = 'approval';

    const UPDATE = 'update';

    const WEEKLY = 'week';

    const MONTHLY = 'month';

    /**
     * Process Flow Model
     *
     * @var collection
     */
    private $flowProcess;

    /**
     * Coporate Id
     * @var int
     */
    private $corporateId;

    /**
     * Collection of profile in same corporation
     *
     * @var Illuminate\Support\Collection
     */
    private $profileInGroup;

    /**
     * Collection of profile from cross corporation
     *
     * @var Illuminate\Support\Collection
     */
    private $profileCrossOrganization;

    /**
     * Collection of profile from parent corporation
     *
     * @var Illuminate\Support\Collection
     */
    private $profileInParentGroup;

    /**
     * Collection mapped flow & steps
     *
     * @var Illuminate\Support\Collection
     */
    private $mappedFlowProcess;

    /**
     * Define Process Flow & Profile For Respective Corporation
     *
     * @param int $corporateId Corporation Id
     */
    public function __construct(int $corporateId)
    {
        $this->corporateId = $corporateId;

        $this->flowProcess = $this->getAllAvailableProcess();

        $this->profileInGroup = $this->sameGroupProfile();

        $this->profileInParentGroup = $this->parentGroupProfile();

        $this->profileCrossOrganization = $this->crossOrgProfile();

        $this->mappedFlowProcess = $this->mappingStepWithProfile();
    }

    /**
     * Mapping All Flow & Step Roles To Respective Profile List
     *
     * @return Illuminate\Support\Collection
     */
    private function mappingStepWithProfile()
    {
        return $this->flowProcess->map(function ($flow) {

            $steps = data_get($flow, 'steps')->map(function ($step) {
                $profile = ($step->cross_organisation == 1) ? $this->profileCrossOrganization : $this->profileInGroup;

                return collect([
                    'cross' => $step->cross_organisation,
                    'order' => $step->order,
                    'id' => $step->id,
                    'label' => strtoupper($step->label),
                    'role' => data_get($step, 'role.role'),
                    'role_id' => data_get($step, 'role.id'),
                    'status' => data_get($step, 'status.description'),
                    'status_id' => data_get($step, 'status.id'),
                    'profile_list' => $profile,
                    'profile_assign' => null
                ]);
            });

            return collect([
                'id' => data_get($flow, 'id'),
                'flow' => ucwords(data_get($flow, 'label')),
                'type' => config('joesama/project::workflow.process.'.$flow->type),
                'type_id' => $flow->type,
                'steps' => $steps
                
            ]);
        });
    }

    /**
     * List all role involve in the process then mapped to cross & role
     *
     * @return Illuminate\Support\Collection
     */
    public function formRoleListing()
    {
        return $this->mappedFlowProcess->pluck('steps')->flatten(1)
                ->groupBy(['cross','role_id','status_id'])->map(function ($crossItem, $cross) {
                    return $crossItem->map(function ($roleItem, $roleId) use ($cross) {
                        return $roleItem->map(function ($statusItem, $statusId) use ($cross, $roleId) {
                            $sub = $statusItem->first();

                            return collect([
                                'identifier' => $cross .'_'. $roleId  .'_'. $statusId,
                                'cross' => $cross,
                                'role_id' => $sub->get('role_id'),
                                'role' => $sub->get('role'),
                                'status' => $sub->get('status'),
                                'status_id' => $sub->get('status_id'),
                                'label' => $statusItem->pluck('label')->implode(' , '),
                                'profile' => $sub->get('profile_list')
                            ]);
                        });
                    });
                })->flatten(2);
    }

    /**
     * Get Steps Model
     *
     * @return Illuminate\Support\Collection
     */
    public function getStepsModel() : Collection
    {
        return $this->flowProcess->pluck('steps')->flatten(1);
    }

    /**
     * Get Process Flow That Assigned To Project
     *
     * @param  Project $project Project Data
     * @return Illuminate\Support\Collection
     */
    public function getAssignedFlowToProject(Project $project, $requiredProfile = false) : Collection
    {
        $profile = $project->profile;

        if (!is_a($this->mappedFlowProcess, Collection::class)) {
            return collect([]);
        }

        return $this->mappedFlowProcess->sortBy('type_id')->map(function ($flow) use ($profile, $requiredProfile) {
            $steps = $flow->get('steps')->sortBy('order')->map(function ($step) use ($profile, $requiredProfile) {

                if (!$requiredProfile) {
                    $step->put('profile_list', []);
                }

                $step->put(
                    'profile_assign',
                    $profile->where('pivot.step_id', $step->get('id'))
                    ->where('pivot.role_id', $step->get('role_id'))->first()
                );

                return $step;
            });

            $flow->put('steps', $steps);

            return $flow;
        });
    }

    /**
     * Get Approval Workflow
     *
     * @param  Project $project Current Project Model
     * @return Illuminate\Support\Collection
     */
    public function getApprovalFlow(Project $project) : Collection
    {
        $steps = $this->getWorkflowSteps($project, self::APPROVAL);

        return $this->workflowPosition(data_get($project, 'approval'), $steps, self::APPROVAL);
    }

    /**

     * Get Update Workflow
     *
     * @param  Project  $project  Current Project Model
     * @param  int|null $updateId Current Update Process
     * @return Illuminate\Support\Collection
     */
    public function getUpdateFlow(Project $project, ?int $updateId = null) : Collection
    {
        $steps = $this->getWorkflowSteps($project, self::UPDATE);

        $updateProcess = collect(data_get($project, 'infoupdate'))->where('id',$updateId)->first();

        return $this->workflowPosition($updateProcess, $steps, self::UPDATE);
    }

    /**

     * Get Weekly Report Workflow
     *
     * @param  Project  $project        Current Project Model
     * @param  int|null $weekReportId   Current Weekly Report Process
     * @return Illuminate\Support\Collection
     */
    public function getWeeklyFlow(Project $project, ?int $weekReportId = null) : Collection
    {
        $steps = $this->getWorkflowSteps($project, self::WEEKLY);

        $updateProcess = collect(data_get($project, 'report'))->where('id',$weekReportId)->first();

        return $this->workflowPosition($updateProcess, $steps, self::WEEKLY);
    }

    /**

     * Get Monthly Report Workflow
     *
     * @param  Project  $project        Current Project Model
     * @param  int|null $monthReportId   Current Weekly Report Process
     * @return Illuminate\Support\Collection
     */
    public function getMonthlyFlow(Project $project, ?int $monthReportId = null) : Collection
    {
        $steps = $this->getWorkflowSteps($project, self::MONTHLY);

        $updateProcess = collect(data_get($project, 'card'))->where('id',$monthReportId)->first();

        return $this->workflowPosition($updateProcess, $steps, self::MONTHLY);
    }

    /**
     * Get All Steps For The Workflow
     *
     * @param  Project $project Current Project Model
     * @param  string  $type    Workflow Type
     * @return Illuminate\Support\Collection
     */
    private function getWorkflowSteps(Project $project, string $type): Collection
    {
        $flow = $this->getAssignedFlowToProject($project)->where('type_id', $type)->first();

        return $flow->get('steps')->sortBy('order');
    }

    /**
     * Get All Position For The Workflow
     *
     * @param               $workflow Assigned Workflow
     * @param  Collection   $steps    List of the workflow steps
     * @param  string       $type     Type of workflow
     * @return Illuminate\Support\Collection
     */
    private function workflowPosition($workflow, Collection $steps, string $type): Collection
    {
        $position = collect([
            'type' => $type,
            'current' => null,
            'first' => $steps->first(),
            'next' => null,
            'last' => $steps->last(),
            'record' => data_get($workflow, 'workflow') ?? collect([])
        ]);

        if ($workflow  == null) {
            $position->put('current', $steps->first());
            $position->put('next', $steps->slice(1, 1)->first());
        } else {
            $needAction = data_get($workflow, 'need_action');

            $needStep = data_get($workflow, 'need_step');

            $currentIndex = $steps->pluck('id')->search($needStep);

            $current = $steps->where('id', $needStep)->where('profile_assign.id', $needAction)->first();

            $position->put('current', $current);

            $position->put('next', $steps->slice(($currentIndex+1), 1)->first());
        }

        $pcess = collect(data_get($workflow, 'workflow'))->groupBy('step_id');

        $progress = $steps->sortBy('order')->mapWithKeys(function ($item, $key) use ($pcess) {

            $condition = [
                'order' => $item['order'],
                'label' => $item['label'],
                'photo' => data_get($item,'profile_assign.user.photo'),
                'profile' => data_get($item,'profile_assign.name'),
                'lastaction' => collect($pcess->get($item['id']))->last(),
            ];

            return [
                $item['id'] => $condition
            ];
        });

        $position->put('progress', $progress);

        return $position;
    }

    /**
     * Retrieve All Process Flow For Corporation
     *
     * @return Illuminate\Eloquent\Collection
     */
    private function getAllAvailableProcess()
    {
        if (!$this->flowProcess) {
            return Flow::sameGroup($this->corporateId)->active()->with([ 'steps' => function ($query) {
                $query->with(['status','role']);
            } ])->get();
        }

        return $this->flowProcess;
    }

    /**
     * Get All Profile In Same Corporation
     *
     * @return Illuminate\Eloquent\Collection
     */
    private function sameGroupProfile()
    {
        if (!$this->profileInGroup) {
            return Profile::sameGroup($this->corporateId)->pluck('name', 'id');
        }

        return $this->profileInGroup;
    }

    /**
     * Get All Profile From Cross Corporation
     *
     * @return Illuminate\Eloquent\Collection
     */
    private function crossOrgProfile()
    {
        if (!$this->profileCrossOrganization) {
            return Profile::crossOrganization()->pluck('name', 'id');
        }

        return $this->profileCrossOrganization;
    }

    /**
     * Get All Profile From Parent Corporation
     *
     * @return Illuminate\Eloquent\Collection
     */
    private function parentGroupProfile()
    {
        if (!$this->profileInParentGroup) {
            return Profile::fromParent()->pluck('name', 'id');
        }

        return $this->profileInParentGroup;
    }
}
