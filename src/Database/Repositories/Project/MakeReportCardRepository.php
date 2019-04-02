<?php
namespace Joesama\Project\Database\Repositories\Project;

use App\Jobs\Joesama\Project\Jobs\MailForAction;
use Carbon\Carbon;
use DB;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Report;
use Joesama\Project\Database\Model\Project\ReportWorkflow;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Data Handling For Create Project Card & Report Record
 *
 * @package default
 * @author
 **/
class MakeReportCardRepository
{
    use HasAccessAs;

    /**
     * Initiate Monthly Report Workflow Processing
     *
     * @param  Request  $request   HTTP input request
     * @param  int      $projectId Current Project Id
     * @param  int      $reportId  Current Report Id
     * @return Joesama\Project\Database\Model\Project\Card
     **/
    public function initMonthly($request, int $projectId, ?int $reportId)
    {
        DB::beginTransaction();

        $currentProfile = $this->profile();

        $endReportDate = Carbon::parse($request->get('end'))->format('Y-m-d');

        try {
            if ($reportId) {
                $report = Card::reporting($endReportDate)->find($reportId);
            } else {
                $report = Card::reporting($endReportDate)->firstOrNew([
                    'month' => (int)$request->get('cycle'),
                    'project_id' => (int)$projectId,
                    'card_date' => Carbon::parse($request->get('start'))->format('Y-m-d'),
                    'card_end' => $endReportDate
                ]);

                $report->creator_id = $currentProfile->id;
            }

            $report->workflow_id = (int)$request->get('status');

            $report->need_action = (int)$request->get('need_action');

            $report->need_step = (int)$request->get('need_step');

            $report->state = (string)$request->get('state');

            $report->save();

            if ($request->get('need_action') == null) {
                $this->lockProjectData($report->project, $report, $request->get('type'));
            }

            $reportWork = new CardWorkflow([
                'remark' => $request->get('remark'),
                'state' => $request->get('state'),
                'step_id' => (int)$request->get('current_step'),
                'profile_id' => (int)$request->get('current_action'),
            ]);

            $report->workflow()->save($reportWork);

            DB::commit();

            $project = $report->project;

            if (!is_null($report->nextby)) {
                $project->profile->groupBy('id')->each(function ($profile) use ($project, $report, $request) {
                    $profile->first()->sendActionNotification($project, $report, $request->get('type'), 'warning');
                });
            } else {
                $report->creator->sendActionNotification($project, $report, $request->get('type'));
            }

            return $report;
        } catch (\Exception $e) {
            DB::rollback();

            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * Initiate Weekly Report Workflow Processing
     *
     * @param  Request  $request   HTTP input request
     * @param  int      $projectId Current Project Id
     * @param  int      $reportId  Current Report Id
     * @return Joesama\Project\Database\Model\Project\Report
     */
    public function initWeeklyWorkflow($request, int $projectId, ?int $reportId)
    {
        DB::beginTransaction();

        $currentProfile = $this->profile();

        $endReportDate = Carbon::parse($request->get('end'))->format('Y-m-d');

        try {
            if ($reportId) {
                $report = Report::reporting($endReportDate)->find($reportId);
            } else {
                $report = Report::reporting($endReportDate)->firstOrNew([
                    'week' => (int)$request->get('cycle'),
                    'project_id' => (int)$projectId,
                    'report_date' => Carbon::parse($request->get('start'))->format('Y-m-d'),
                    'report_end' => $endReportDate
                ]);

                $report->creator_id = $currentProfile->id;
            }

            $report->workflow_id = (int)$request->get('status');

            $report->need_action = (int)$request->get('need_action');

            $report->need_step = (int)$request->get('need_step');

            $report->state = (string)$request->get('state');
dd($report);
            $report->save();

            if ($request->get('need_action') == null) {
                $this->lockProjectData($report->project, $report, $request->get('type'));
            }

            $reportWork = new ReportWorkflow([
                'remark' => $request->get('remark'),
                'state' => $request->get('state'),
                'step_id' => (int)$request->get('current_step'),
                'profile_id' => (int)$request->get('current_action'),
            ]);

            $report->workflow()->save($reportWork);

            DB::commit();

            $project = $report->project;

            if (!is_null($report->nextby)) {
                $project->profile->groupBy('id')->each(function ($profile) use ($project, $report, $request) {
                    $profile->first()->sendActionNotification($project, $report, $request->get('type'), 'warning');
                });
            } else {
                $report->creator->sendActionNotification($project, $report, $request->get('type'));
            }
            return $report;
        } catch (\Exception $e) {
            DB::rollback();

            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * Create Monthly Card Workflow
     *
     * @param  Report   $report       Get Report Header
     * @param  int      $profile      Profile Id
     * @param  array    $workflowData Get Form Data
     * @return JJoesama\Project\Database\Model\Project\Card
     **/
    public function initMonthlyWorkflow(
        Card $card,
        int $profile,
        array $workflowData
    ) {
        DB::beginTransaction();

        try {
            $workflow = new CardWorkflow([
                'remark' => array_get($workflowData, 'remark'),
                'state' => array_get($workflowData, 'status'),
                'profile_id' => $profile,
            ]);

            $card->workflow()->save($workflow);

            DB::commit();

            return $card;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Lock Project Data
     *
     * @param string $type      Report Type
     * @param Report $project   Project Data
     **/
    public function lockProjectData(Project $project, $report, string $type)
    {
        $tasks = $project->task;
        $payment = $project->payment;
        $nextWeekPlan = $project->plan;

        $tasks->each(function ($task) use ($type, $report) {
            $progress = $task->allProgress;

            $progress->each(function ($prog) use ($type, $report) {
                if ($type == 'week') {
                    $prog->report_id = $report->id;
                }

                if ($type == 'month') {
                    $prog->card_id = $report->id;
                }

                $prog->save();
            });

            if ($progress->isNotEmpty()) {
                $task->actual_progress = $progress->last()->progress/100*$task->planned_progress;
                $task->save();
            }
        });

        $payment->each(function ($claim) use ($type, $report) {
            if ($type == 'week') {
                $claim->report_id = $report->id;
            }

            if ($type == 'month') {
                $claim->card_id = $report->id;
            }

            $claim->save();
        });

        $nextWeekPlan->each(function ($planning) use ($type, $report) {
            if ($type == 'week') {
                $planning->report_id = $report->id;
            }

            if ($type == 'month') {
                $planning->card_id = $report->id;
            }

            $planning->save();
        });
    }
} // END class MakeReportCardRepository
