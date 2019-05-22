<?php
namespace Joesama\Project\Http\Processors\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\ProcessFlowManager;
use Joesama\Project\Http\Traits\PrintingView;
use Joesama\Project\Traits\HasAccessAs;
use Joesama\Project\Traits\ProjectCalculator;

/**
 * Client Record
 *
 * @package default
 * @author
 **/
class WeeklyProcessor
{
    use HasAccessAs, ProjectCalculator, PrintingView;
    
    private $reportCard;

    public function __construct(
        ProjectInfoRepository $projectInfo,
        ReportCardInfoRepository $reportCardInfo
    ) {
        $this->projectInfo = $projectInfo;
        $this->reportCard = $reportCardInfo;
        $this->profile();
    }


    /**
     * @param  Request $request
     * @param  int $corporateId
     * @return mixed
     */
    public function list(Request $request, int $corporateId)
    {
        $table = app(ListProcessor::class)->weeklyReportHistory($request);

        return compact('table');
    }

    /**
     * Redirecting current report to exact uri
     *
     * @param  int    $reportId  Current report id
     * @param  Request $request  [description]
     * @return [type]            [description]
     */
    public function redirect(Request $request, int $reportId)
    {
        $report = $this->reportCard->getWeeklyReportInfo($reportId);

        return redirect(
            handles('report/weekly/form/'.$report->project->corporate_id.'/'.$report->project_id.'/'.$reportId)
        );
    }

    /**
     * Weekly Report Form
     *
     * @param  Request $request
     * @param  int     $corporateId  Corporate Id
     * @param  int     $projectId    Project Id
     * @return array
     */
    public function form(Request $request, int $corporateId, $projectId)
    {
        $reportId = $request->segment(6);

        if ($reportId !== null) {
            $report = $this->reportCard->getWeeklyReportInfo($reportId);

            $projectId = data_get($report, 'project_id');

            $project = data_get($report, 'project');
        } else {
            $report = false;

            $project = $this->projectInfo->getProject($projectId, 'week');
        }

        $processFlow = new ProcessFlowManager($project->corporate_id);

        $projectDate = Carbon::parse($project->start);

        $today = Carbon::now();

        $reportDue = $this->calculateWeek($today, $projectDate);

        $startOfWeek = $today->startOfWeek();

        $startOfWeek = $projectDate->greaterThan($startOfWeek) ? $projectDate : $startOfWeek;

        $reportStart = ($report) ? Carbon::parse($report->report_date) : $startOfWeek;

        $endOfWeek = $today->clone()->endOfWeek();

        $endOfWeek = $projectDate->greaterThan(Carbon::now()->startOfWeek()) ? $projectDate->clone()->endOfWeek() : $endOfWeek;

        $reportEnd = ($report) ? Carbon::parse($report->report_end) : $endOfWeek;

        $workflow = $processFlow->getWeeklyFlow($project, $reportId);

        $reportInit = $projectDate->isLastWeek() || $projectDate->lessThan(Carbon::now()->isLastWeek()) ? 1 : 0;

        $lastAction = collect(data_get($report, 'workflow'))
        ->where('state', strtolower(data_get($workflow, 'last.status')))
        ->where('profile_id', strtolower(data_get($workflow, 'last.profile_assign.id')));

        $printed = $lastAction->count();

        $params = compact('project', 'reportDue', 'reportStart', 'reportEnd', 'corporateId', 'projectId', 'workflow', 'printed', 'reportId');

        if ($request->get('print') == true) {
            $this->printReport('joesama/project::report.format-weekly', $params, 'Weekly');
        }

        return $params;
    }
} // END class ClientProcessor
