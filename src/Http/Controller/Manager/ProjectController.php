<?php
namespace Joesama\Project\Http\Controller\Manager;

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Controller\BaseController;

/**
 * Dashboard Controller
 */
class ProjectController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		if( $request->segment(5) == 'report' && !is_null($request->segment(6))){
			$report = app(ReportCardInfoRepository::class)->getMonthlyReportInfo($request->segment(6));
			$projectId = data_get($report,'project_id');

			return redirect(handles('joesama/project::manager/project/view/'.$corporateId.'/'.$projectId.'/'.$report->id));
		}{
			$report = FALSE;
		}

		parent::__construct($request);

		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->domain.'.'.$this->page,
			app($this->processor)->$page($request,$corporateId)
		);
	}
} // END class ProjectController  