<?php
namespace Joesama\Project\Database\Repositories\Project;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DB;
use Exception;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Attribute;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\FinanceMilestone;
use Joesama\Project\Database\Model\Project\HseScore;
use Joesama\Project\Database\Model\Project\Incident;
use Joesama\Project\Database\Model\Project\Issue;
use Joesama\Project\Database\Model\Project\PhysicalMilestone;
use Joesama\Project\Database\Model\Project\Plan;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\ProjectInfo;
use Joesama\Project\Database\Model\Project\ProjectLad;
use Joesama\Project\Database\Model\Project\ProjectPayment;
use Joesama\Project\Database\Model\Project\ProjectRetention;
use Joesama\Project\Database\Model\Project\ProjectVo;
use Joesama\Project\Database\Model\Project\Risk;
use Joesama\Project\Database\Model\Project\TagMilestone;
use Joesama\Project\Database\Model\Project\Task;
use Joesama\Project\Database\Model\Project\TaskProgress;
use Joesama\Project\Database\Repositories\Project\MilestoneRepository;
use Joesama\Project\Http\Services\ProcessFlowManager;
use Joesama\Project\Traits\HasAccessAs;
use Joesama\Project\Traits\ProjectCalculator;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author
 **/
class MakeProjectRepository
{
    use ProjectCalculator,HasAccessAs;

    public function __construct(
        Project $project,
        Client $client,
        Task $task,
        Plan $plan,
        Issue $issue,
        Risk $risk
    ) {
        $this->projectModel = $project;
        $this->clientModel = $client;
        $this->taskModel = $task;
        $this->planModel = $plan;
        $this->issueModel = $issue;
        $this->riskModel = $risk;
    }

    /**
     * Create New Project
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initProject($projectData, $id = null)
    {
        $inputData = collect($projectData)->intersectByKeys([
            'client_id' => 0,
            'corporate_id' => 0,
            'name' => null,
            'value' => null,
            'contract' => null,
            'gp_propose' => null,
            'job_code' => null,
            'gp_latest' => null,
            'bond' => null,
            'scope' => null,
            'start' => null,
            'end' => null,
            'active' => 0
        ]);

        $processFlow = new ProcessFlowManager($projectData->get('corporate_id'));

        $steps = $processFlow->getStepsModel();

        $stepsAssign = collect([]);

        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->projectModel = $this->projectModel->find($id);
            }

            if ($this->projectModel->active != 1) {

                $projectData->except(['_token','files'])->diff($inputData)
                ->each( function($profile, $identifier) use ($steps, $stepsAssign){

                    $identifier = explode("_",$identifier);

                    $cross = $identifier[0];

                    $role = $identifier[1];

                    $status = $identifier[2];

                    $steps->where('role_id',$role)
                        ->where('status_id',$status)
                            ->where('cross_organisation',$cross)
                                ->each( function($step) use ($stepsAssign, $profile, $role){

                                    $stepsAssign->push([
                                        $profile => [
                                            'role_id' => intval($role), 
                                            'step_id' => $step->id,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now()
                                        ]
                                    ]);
                                });
                });

                $inputData->each(function ($record, $field) {
                    if (!is_null($record)) {
                        if (in_array($field, ['start','end'])) :
                            $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                        endif;
                        
                        $this->projectModel->{$field} = $record;
                    }
                });

                // Create HSE Card for project
                if (is_null($id)) {
                    $startDate = Carbon::parse($this->projectModel->start);

                    $endDate = Carbon::parse($this->projectModel->end);

                    $hse = new HseScore();

                    $hse->project_hour = $startDate->diffInHours($endDate);

                    $hse->save();

                    $this->projectModel->active = 0;
                    $this->projectModel->hse_id = $hse->id;
                    $this->projectModel->effective_days = $this->effectiveDays($this->projectModel->start, $this->projectModel->end);

                    $projectAdmin = Profile::where('user_id', auth()->id())->with('role')->first();

                    $this->projectModel->profile()->attach($projectAdmin->id, ['role_id' => 1]);
                }

                $this->projectModel->save();

                // Create Physical & Financial Milestones
                if ( $this->projectModel->physical->count() == 0 ) {
                    $period = CarbonInterval::month()->toPeriod($this->projectModel->start, $this->projectModel->end);

                    foreach ($period as $key => $date) {
                        $progressDate = $date->endOfMonth()->format('Y-m-d');

                        $label = $date->format('j M Y');

                        $this->projectModel->physical()->save(
                            new PhysicalMilestone([
                                'label' => $label,
                                'progress_date' => $progressDate,
                            ])
                        );

                        $this->projectModel->finance()->save(
                            new FinanceMilestone([
                                'label' => $label,
                                'progress_date' => $progressDate,
                            ])
                        );
                    }
                }

                // Assign Role
                $stepsAssign->each(function($step) {
                	$this->projectModel->profile()->attach($step);
                });

                // Generate Approval Workflow
                if (is_null($id)) {
                    $approvalFlow = $processFlow->getApprovalFlow($this->projectModel);

                    $approval = new ProjectWorkflowRepository();

                    $approval->registerProject($this->projectModel,$approvalFlow);
                }
            } 
            else 
            {
                $requestedInfo = new ProjectInfo();

                $inputData->each(function ($record, $field) use ($requestedInfo) {
                    if ($record != null) {
                        if (in_array($field, ['start','end'])) :
                            $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                        endif;
                        $requestedInfo->{$field} = $record;
                    }
                });

                $requestedInfo->project_id = $this->projectModel->id;

                $requestedInfo->save();

                // Create Update Workflow
                $processflow = $processFlow->getUpdateFlow($this->projectModel);

                $updateFlow = new ProjectUpdateWorkflowRepository;

                $updateFlow->registerInfoWorkflow($requestedInfo, $processflow);
            }

            DB::commit();

            return $this->projectModel;
        } catch (Exception $e) {

            DB::rollback();

            throw new Exception($e->getMessage(), 1);
        }
    }

    /**
     * Create New Client
     *
     * @return Joesama\Project\Database\Model\Project\Client
     **/
    public function initClient(\Illuminate\Support\Collection $clientData, $id = null)
    {
        $inputData = collect($clientData)->intersectByKeys([
            'name' => null,
            'corporate_id' => null,
            'phone' => null,
            'contact'=> null,
            'manager' => null
        ]);

        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->clientModel = $this->clientModel->find($id);
            }

            $inputData->each(function ($record, $field) {
                if (!is_null($record)) {
                    $this->clientModel->{$field} = $record;
                }
            });

            $this->clientModel->save();

            DB::commit();

            return $this->clientModel;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 1);
            
            DB::rollback();
        }
    }

    /**
     * Create New Task
     *
     * @return Joesama\Project\Database\Model\Project\Task
     **/
    public function initTask(\Illuminate\Support\Collection $taskData, $id = null)
    {
        $inputData = collect($taskData)->intersectByKeys([
            'name' => null,
            'project_id' => null,
            'profile_id' => null,
            'start'=> null,
            'end' => null,
            'status_id' => null,
            'indicator_id' => null,
            'description' => null,
        ]);
                
        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->taskModel = $this->taskModel->find($id);
            }

            $inputData->each(function ($record, $field) {
                if (!is_null($record)) {
                    if (in_array($field, ['start','end'])) :
                        $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                    endif;

                    $this->taskModel->{$field} = $record;
                }
            });

            $totalDay = Project::find($this->taskModel->project_id)->effective_days;

            $effectiveDay = $taskData->get('days');
                        
            $this->taskModel->planned_progress = !is_null($taskData->get('planned_progress')) ?  $taskData->get('planned_progress') : round($effectiveDay/$totalDay * 100, 2);

            $this->taskModel->actual_progress = ($this->taskModel->planned_progress/100)*$taskData->get('task_progress');

            $this->taskModel->effective_days = $effectiveDay;

            $this->taskModel->save();

            $this->taskModel->progress()->save(new TaskProgress([
                'progress' => ($taskData->get('task_progress') > 100) ? 100 : $taskData->get('task_progress', 0)
            ]));

            $tag = TagMilestone::firstOrNew(['label' => strtoupper($taskData->get('group'))]);

            $this->taskModel->tags()->detach();

            $this->taskModel->tags()->save($tag);

            DB::commit();
                        
            return $this->taskModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove task attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $taskId       Specific task id
     * @return
     */
    public function deleteTask(int $corporateId, int $projectId, int $taskId)
    {
        DB::beginTransaction();

        try {
            $this->taskModel->find($taskId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }
    
    /**
     * Create New Plan
     *
     * @return Joesama\Project\Database\Model\Project\Plan
     **/
    public function initPlan(\Illuminate\Support\Collection $planData, $id = null)
    {
        $inputData = collect($planData)->intersectByKeys([
            'name' => null,
            'project_id' => null,
            'profile_id' => null,
            'start'=> null,
            'end' => null,
            'status_id' => null,
            'indicator_id' => null,
            'description' => null,
        ]);
                
        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->planModel = $this->planModel->find($id);
            }

            $inputData->each(function ($record, $field) {
                if (!is_null($record)) {
                    if (in_array($field, ['start','end'])) :
                        $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                    endif;

                    $this->planModel->{$field} = $record;
                }
            });

            $totalDay = Project::find($this->planModel->project_id)->effective_days;

            $effectiveDay = $planData->get('days');
                        
            $this->planModel->planned_progress = !is_null($planData->get('planned_progress')) ?  $planData->get('planned_progress') : round($effectiveDay/$totalDay * 100, 2);

            $this->planModel->actual_progress = ($this->planModel->planned_progress/100)*$planData->get('task_progress');

            $this->planModel->effective_days = $effectiveDay;

            $this->planModel->save();

            DB::commit();
                        
            return $this->planModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }
    
    /**
     * Remove plan attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $planId       Specific plan id
     * @return
     */
    public function deletePlan(int $corporateId, int $projectId, int $planId)
    {
        DB::beginTransaction();

        try {
            $this->planModel->find($taskId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Issue
     *
     * @return Joesama\Project\Database\Model\Project\Issue
     **/
    public function initIssue(Collection $issueData, $id = null)
    {
        $inputData = collect($issueData)->intersectByKeys([
            'name' => null,
            'project_id' => null,
            'profile_id' => null,
            'progress_id'=> null,
            'indicator_id'=> null,
            'label'=> null,
            'description' => null
        ]);

        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->issueModel = $this->issueModel->find($id);
            }

            $inputData->each(function ($record, $field) {
                if (!is_null($record)) {
                    if (in_array($field, ['start','end'])) :
                        $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                    endif;

                    $this->issueModel->{$field} = $record;
                }
            });

            $this->issueModel->save();

            DB::commit();

            return $this->issueModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove issue attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $taskId       Specific task id
     * @return
     */
    public function deleteIssue(int $corporateId, int $projectId, int $taskId)
    {
        DB::beginTransaction();

        try {
            $this->issueModel->find($taskId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Risk
     *
     * @return Joesama\Project\Database\Model\Project\Risk
     **/
    public function initRisk(Collection $riskData, $id = null)
    {
        $inputData = collect($riskData)->intersectByKeys([
            'name' => null,
            'project_id' => null,
            'severity_id'=> null,
            'description' => null,
                    'status_id'=> null,
        ]);

        DB::beginTransaction();

        try {
            if (!is_null($id)) {
                $this->riskModel = $this->riskModel->find($id);
            }

            $inputData->each(function ($record, $field) {
                if (!is_null($record)) {
                    if (in_array($field, ['start','end'])) :
                        $record = Carbon::createFromFormat('d/m/Y', $record)->toDateTimeString();
                    endif;

                    $this->riskModel->{$field} = $record;
                }
            });

            $this->riskModel->save();

            DB::commit();

            return $this->riskModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove risk attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $taskId       Specific task id
     * @return
     */
    public function deleteRisk(int $corporateId, int $projectId, int $riskId)
    {
        DB::beginTransaction();

        try {
            $this->riskModel->find($riskId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Partner
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initPartner(Collection $partnerData, $id = null)
    {
        $inputData = collect($partnerData)->intersectByKeys([
            'partner_id'=> null
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find($id);
            $this->projectModel->partner()->detach(data_get($inputData, 'partner_id'));
            $this->projectModel->partner()->attach(data_get($inputData, 'partner_id'));

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove partner attached to project
     *
     * @param  int    $corporateId Corporate Id
     * @param  int    $projectId   Project Id
     * @param  int    $partnerId   Specific partner id
     * @return
     */
    public function deletePartner(int $corporateId, int $projectId, int $partnerId)
    {
        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find($projectId);
            $this->projectModel->partner()->detach($partnerId);

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Attribute
     *
     * @return Joesama\Project\Database\Model\Project\Attribute
     **/
    public function initAttribute(Collection $partnerData, $id = null)
    {
        $inputData = collect($partnerData)->intersectByKeys([
            'project_id'=> null,
            'variable'=> null,
            'data'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));

            $attr = new Attribute([
                'variable'=> data_get($inputData, 'variable'),
                'data'=> data_get($inputData, 'data')
            ]);

            $this->projectModel->attributes()->save($attr);

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove attributes attached to project
     *
     * @param  int    $corporateId Corporate Id
     * @param  int    $projectId   Project Id
     * @param  int    $attributeId   Specific attribute id
     * @return
     */
    public function deleteAttribute(int $corporateId, int $projectId, int $attributeId)
    {
        DB::beginTransaction();

        try {
            Attribute::where('project_id', $projectId)->where('id', $attributeId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Incident Report
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initIncident(Collection $partnerData, $id = null)
    {
        $inputData = collect($partnerData)->intersectByKeys([
            'project_id'=> null,
            'incident_id'=> null,
            'report_by'=> null,
            'incident'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));

            if (!is_null($id)) {
                $incident = Incident::find($id);

                $incident->incident_id = data_get($inputData, 'incident_id');

                $incident->incident = data_get($inputData, 'incident');

                $incident->report_by = data_get($inputData, 'report_by');

                $incident->save();
            } else {
                $incident = new Incident([
                    'incident_id'=> data_get($inputData, 'incident_id'),
                    'incident'=> data_get($inputData, 'incident'),
                    'report_by'=> data_get($inputData, 'report_by')
                ]);

                $this->projectModel->incident()->save($incident);
            }

            $currentIncident = data_get($inputData, 'incident_id');

            $scoreCard = $this->projectModel->hsecard;

            $incidentRecord = $this->projectModel->incident;

            $incidentGroup = $incidentRecord->groupBy('incident_id');

            $scoreCard->update([
                'acc_lti' => collect($incidentGroup->get(15))->sum('incident'), //8
                'zero_lti' => 0, //9
                'unsafe' => collect($incidentGroup->get(16))->sum('incident'),//9
                'stop' => collect($incidentGroup->get(17))->sum('incident'),//10
                'summon' => collect($incidentGroup->get(18))->sum('incident'),//11
                'complaint' => collect($incidentGroup->get(19))->sum('incident') //12
            ]);

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }


    /**
     * Remove incident attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $incidentId       Specific task id
     * @return
     */
    public function deleteIncident(int $corporateId, int $projectId, int $incidentId)
    {
        DB::beginTransaction();

        try {
            Incident::find($incidentId)->delete();

            $this->projectModel = $this->projectModel->find($projectId);

            $scoreCard = $this->projectModel->hsecard;
            $incidentRecord = $this->projectModel->incident;
            $incidentGroup = $incidentRecord->groupBy('incident_id');

            $scoreCard->update([
                'acc_lti' => collect($incidentGroup->get(15))->sum('incident'), //8
                'zero_lti' => 0, //9
                'unsafe' => collect($incidentGroup->get(16))->sum('incident'),//9
                'stop' => collect($incidentGroup->get(17))->sum('incident'),//10
                'summon' => collect($incidentGroup->get(18))->sum('incident'),//11
                'complaint' => collect($incidentGroup->get(19))->sum('incident') //12
            ]);
            
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Claim Report
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initClaim(Collection $claimData, $id = null)
    {
        $inputData = collect($claimData)->intersectByKeys([
            'project_id'=> null,
            'claim_date'=> null,
            'claim_report_by'=> null,
            'claim_amount'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));

            $claim = new ProjectPayment([
                'claim_date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'claim_date'))->toDateTimeString(),
                'claim_amount'=> data_get($inputData, 'claim_amount'),
                'claim_report_by'=> data_get($inputData, 'claim_report_by')
            ]);

            $this->projectModel->payment()->save($claim);

            $tag = TagMilestone::firstOrNew(['label' => strtoupper($claimData->get('group'))]);

            $claim->tags()->detach();
            $claim->tags()->save($tag);

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New Incident Report
     *
     * @return Joesama\Project\Database\Model\Project\ProjectPayment
     **/
    public function updateClaim(Collection $claimData, $id)
    {
        $inputData = collect($claimData)->intersectByKeys([
            'paid_date'=> null,
            'paid_amount'=> null,
            'paid_report_by'=> null,
            'reference'=> null,
        ]);

        DB::beginTransaction();

        try {
            $payment = ProjectPayment::find($id);
            $payment->paid_date = Carbon::createFromFormat('d/m/Y', data_get($inputData, 'paid_date'))->toDateTimeString();
            $payment->paid_amount = data_get($inputData, 'paid_amount');
            $payment->paid_report_by = data_get($inputData, 'paid_report_by');
            $payment->reference = data_get($inputData, 'reference');
            $payment->save();

            $tag = TagMilestone::firstOrNew(['label' => strtoupper($claimData->get('group'))]);

            $payment->tags()->detach();
            $payment->tags()->save($tag);

            DB::commit();

            return $payment;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove attributes attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $claimId      Specific attribute id
     * @return
     */
    public function deleteClaim(int $corporateId, int $projectId, int $claimId)
    {
        DB::beginTransaction();

        try {
            ProjectPayment::find($claimId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New VO
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initVo(Collection $voData, $id = null)
    {
        $inputData = collect($voData)->intersectByKeys([
            'project_id'=> null,
            'date'=> null,
            'report_by'=> null,
            'amount'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));
            
            if (is_null($id)) {
                $vo = new ProjectVo([
                'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                'amount'=> data_get($inputData, 'amount'),
                'report_by'=> data_get($inputData, 'report_by')
                ]);

                $this->projectModel->vo()->save($vo);
            } else {
                ProjectVo::find($id)->update([
                    'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                    'amount'=> data_get($inputData, 'amount'),
                    'report_by'=> data_get($inputData, 'report_by')
                ]);
            }

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove attributes attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $voId         Specific attribute id
     * @return
     */
    public function deleteVo(int $corporateId, int $projectId, int $voId)
    {
        DB::beginTransaction();

        try {
            ProjectVo::find($voId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New VO
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initRetention(Collection $retentionData, $id = null)
    {
        $inputData = collect($retentionData)->intersectByKeys([
            'project_id'=> null,
            'date'=> null,
            'report_by'=> null,
            'amount'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));

            if (is_null($id)) {
                $vo = new ProjectRetention([
                'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                'amount'=> data_get($inputData, 'amount'),
                'report_by'=> data_get($inputData, 'report_by')
                ]);

                $this->projectModel->retention()->save($vo);
            } else {
                ProjectRetention::find($id)->update([
                    'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                    'amount'=> data_get($inputData, 'amount'),
                    'report_by'=> data_get($inputData, 'report_by')
                ]);
            }

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove attributes attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $retentionId  Specific attribute id
     * @return
     */
    public function deleteRetention(int $corporateId, int $projectId, int $retentionId)
    {
        DB::beginTransaction();

        try {
            ProjectRetention::find($retentionId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Create New LAD
     *
     * @return Joesama\Project\Database\Model\Project\Project
     **/
    public function initLad(Collection $ladData, $id = null)
    {
        $inputData = collect($ladData)->intersectByKeys([
            'project_id'=> null,
            'date'=> null,
            'report_by'=> null,
            'amount'=> null,
        ]);

        DB::beginTransaction();

        try {
            $this->projectModel = $this->projectModel->find(data_get($inputData, 'project_id'));

            if (is_null($id)) {
                $vo = new ProjectLad([
                'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                'amount'=> data_get($inputData, 'amount'),
                'report_by'=> data_get($inputData, 'report_by')
                ]);

                $this->projectModel->lad()->save($vo);
            } else {
                ProjectLad::find($id)->update([
                    'date'=> Carbon::createFromFormat('d/m/Y', data_get($inputData, 'date'))->toDateTimeString(),
                    'amount'=> data_get($inputData, 'amount'),
                    'report_by'=> data_get($inputData, 'report_by')
                ]);
            }

            DB::commit();

            return $this->projectModel;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Remove attributes attached to project
     *
     * @param  int    $corporateId  Corporate Id
     * @param  int    $projectId    Project Id
     * @param  int    $ladId        Specific attribute id
     * @return
     */
    public function deleteLad(int $corporateId, int $projectId, int $ladId)
    {
        DB::beginTransaction();

        try {
            ProjectLad::find($ladId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }
} // END class MakeProjectRepository
