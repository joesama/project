<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\ReportWorkflow;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class WeeklyProcessor 
{
	private $project;

	public function __construct(
		ProjectInfoRepository $projectInfo
	){
		$this->projectInfo = $projectInfo;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		
		return [];
	}

	/**
	 * Weekly Report Form
	 * 
	 * @param  Request $request     
	 * @param  int     $corporateId  Corporate Id
	 * @param  int     $projectId    Project Id
	 * @return array
	 */
	public function form(Request $request, int $corporateId, int $projectId)
	{
		$project = $this->projectInfo->getProject($projectId);
		$reportDue = Carbon::now()->weekOfYear;
		$reportStart = Carbon::now()->startOfWeek()->format('d-m-Y');
		$reportEnd = Carbon::now()->endOfWeek()->format('d-m-Y');

		$workflow = collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$projectId){
			return [
				'weekly' => ReportWorkflow::whereHas('report',function($query) use($projectId){
								$query->where('project_id',$projectId);
								$query->whereBetween('report_date',[ Carbon::now()->startOfMonth() , Carbon::now()->endOfMonth() ]);
							})->with('report')->first(),
				'profile' => Profile::where('corporate_id',$corporateId)->whereHas('role',function($query) use($projectId,$role){
								$query->where('project_id',$projectId);
								$query->where('role_id',$role);
							})->with('role')->first()
			];
		});

		return compact('project','reportDue','reportStart','reportEnd','corporateId','projectId','workflow');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{

		return [];
	}

} // END class ClientProcessor 