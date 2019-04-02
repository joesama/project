<?php
namespace Joesama\Project\Http\Processors\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\ProcessFlowManager;
use Joesama\Project\Traits\HasAccessAs;
use Barryvdh\DomPDF\Facade as PDF;

/**
 * Client Record
 *
 * @package default
 * @author
 **/
class WeeklyProcessor
{
    use HasAccessAs;
    
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

        if ($reportId !== NULL) {
            $report = $this->reportCard->getWeeklyReportInfo($reportId);

            $projectId = data_get($report, 'project_id');

            $project = data_get($report, 'project');
        }else{
            $report = false;

        	$project = $this->projectInfo->getProject($projectId,'week');
        }

        $processFlow = new ProcessFlowManager($project->corporate_id);

        $projectDate = Carbon::parse($project->start);

        $reportDue = Carbon::now()->weekOfYear - $projectDate->weekOfYear;

        $startOfWeek = Carbon::now()->startOfWeek();

        $startOfWeek = $projectDate->greaterThan($startOfWeek) ? $projectDate : $startOfWeek;

        $reportStart = ($report) ? Carbon::parse($report->report_date) : $startOfWeek;

        $endOfWeek = Carbon::now()->endOfWeek();

        $endOfWeek = $projectDate->greaterThan(Carbon::now()->startOfWeek()) ? $projectDate->clone()->endOfWeek() : $endOfWeek;

        $reportEnd = ($report) ? Carbon::parse($report->report_end) : $endOfWeek;

        $workflow = $processFlow->getWeeklyFlow($project, $reportId);

        $reportInit = $projectDate->isLastWeek() || $projectDate->lessThan(Carbon::now()->isLastWeek()) ? 1 : 0;

        $printed = collect(data_get($report, 'workflow'))->where('state', 'accepted')->count();

        $params = compact('project', 'reportDue', 'reportStart', 'reportEnd', 'corporateId', 'projectId', 'workflow', 'printed', 'reportId');

        if ($request->get('print') == true) {
            $this->printReport($params);
        }

        return $params;
    }

    /**
     * @param  Request $request
     * @param  int $corporateId
     * @return mixed
     */
    public function printReport($params)
    {
        $html = '<!DOCTYPE html><html lang="en"><head>';
        $html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= '<link href="'. asset('packages/joesama/entree/css/bootstrap.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/css/font-awesome.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/css/nifty.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/premium/icon-sets/icons/line-icons/premium-line-icons.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/plugins/ionicons/css/ionicons.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link rel="stylesheet" href="'.public_path().'/packages/joesama/entree/css/nifty.css" media="all" />';
        $html .= '</head><body>';
        $html .= '<div class="row"><div class="col-lg-12 col-md-12  col-sm-12">';
        // $html .= '<div class="row mb-3"><div class="col-md-12"><div class="panel"><div class="panel-body">';

        $html .= view('joesama/project::report.format', $params);

        // $html .= '</div></div></div></div>';
        $html .= '</div></div>';
        $html .= '</body></html>';

        $storage = public_path('weekly');

        if (!is_dir($storage)) :
            mkdir($storage, 0777, true);
        endif;

        $fonts = storage_path('fonts');

        if (!is_dir($fonts)) :
            mkdir($fonts, 0777, true);
        endif;

        $reportName = '/weekly'.data_get($params, 'reportDue').'.pdf';
        $pdfReport = $storage.$reportName;

        PDF::setOptions(['isHtml5ParserEnabled' => true,'dpi' => 76,'enable_php' =>true]);

        PDF::loadHTML($html)->setWarnings(false)->save($pdfReport);

        if (file_exists($pdfReport)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.basename($pdfReport).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($pdfReport));
            flush(); // Flush system output buffer
            readfile($pdfReport);
            exit;
        }
    }
} // END class ClientProcessor
