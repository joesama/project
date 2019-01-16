<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\Report;
use Joesama\Project\Database\Model\Project\ReportWorkflow;


class ReportCardInfoRepository 
{	
	private $reportObj, $cardObj;

	public function __construct(
		Report $report,
		Card $card
	)
	{
		$this->reportObj = $report;
		$this->cardObj = $card;
		$this->profile = Profile::where('user_id',auth()->id())->first();
	}

	/**
	 * Get Weekly Project List
	 * 
	 * @param  int    $corporateId Subsidiary Id
	 * @param  int    $projectId   Project Id
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function weeklyList(int $corporateId, ?int $projectId)
	{
		return $this->reportObj->where(function($query){

					$query->whereHas('project',function($query){
						$query->whereHas('manager',function($query){
							$query->where('profile_id',$this->profile->id);
						});
					});

					$query->orWhere('need_action',$this->profile->id);
					
				})->component()
				->paginate();
	}


	/**
	 * Weekly Report Workflow
	 * 
	 * @param  int    $corporateId Corporate Id
	 * @param  int    $projectId   Project Id
	 * @return Collection
	 */
	public function weeklyWorkflow(int $corporateId, int $projectId)
	{
		return collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$projectId){

			if(in_array($state,[19,20])){
				$profile = Profile::whereHas('role',function($query) use($projectId,$role){
								$query->where('project_id',$projectId);
								$query->where('role_id',$role);
							})->with('role')->first();
			}else{
				$profile = Profile::whereHas('corporate',function($query){
								$query->isParent();
							})->whereHas('role',function($query) use($projectId,$role){
								$query->where('role_id',$role);
							})->with('role')->first();
			}

			$status = strtolower(MasterData::find($state)->description);

			return [
				'status' => $status,
				'weekly' => ReportWorkflow::whereHas('report',function($query) use($projectId){
								$query->where('project_id',$projectId);
								$query->whereBetween('report_date',[ Carbon::now()->startOfWeek() , Carbon::now()->endOfWeek() ]);
							})->where('state',$status)->with('report')->first(),
				'profile' => $profile
			];
		});
	}

} // END class ReportCardInfoRepository 