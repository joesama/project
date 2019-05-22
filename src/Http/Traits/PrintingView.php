<?php
namespace Joesama\Project\Http\Traits;

use Barryvdh\DomPDF\Facade as PDF;

trait PrintingView
{

    /**
     * Print html format
     *
     * @param  string $view   View path
     * @param  array  $params Parameter to implements in view
     * @param  string $name   Report file name
     * @return [type]         [description]
     */
    public function printReport(string $view, array $params, string $name = 'Report')
    {
        $html = '<!DOCTYPE html><html lang="en"><head>';
        $html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= '<link href="'. asset('packages/joesama/entree/css/bootstrap.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/css/font-awesome.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/css/nifty.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/premium/icon-sets/icons/line-icons/premium-line-icons.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css') .'" rel="stylesheet" media="all">';
        $html .= '<link href="'. asset('packages/joesama/entree/plugins/ionicons/css/ionicons.min.css') .'" rel="stylesheet" media="all">';
        // $html .= '<link rel="stylesheet" href="'.asset('/packages/joesama/entree/css/nifty.css').'" media="all" />';
        $html .= '<style>@page { margin: 0em;padding:0em }body { margin: 0em;padding:0em }</style>';
        $html .= '</head><body>';
        $html .= '<div id="container"><div class="boxed">';
        $html .= '<div id="content-container"><div id="page-content" style="background:transparent">';
        // $html .= '<div class="row mb-3"><div class="col-md-12"><div class="panel"><div class="panel-body">';

        $html .= view($view, $params)->render();

        // $html .= '</div></div></div></div>';
        $html .= '</div></div>';
        $html .= '</div></div>';
        $html .= '</body></html>';

        $storage = public_path(strtolower($name));

        if (!is_dir($storage)) :
            mkdir($storage, 0777, true);
        endif;

        $fonts = storage_path('fonts');

        if (!is_dir($fonts)) :
            mkdir($fonts, 0777, true);
        endif;

        $reportName = $name . '_' . data_get($params, 'reportDue').'.pdf';
        $pdfReport = $storage . '/' . $reportName;

        PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'dpi' => 96,
            'enable_php' =>true,
            'enable_font_subsetting' =>true,
            'default_media_type' => 'screen',
            'default_font' => 'arial',
            'font_height_ratio' => 0.5
        ]);

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
}
