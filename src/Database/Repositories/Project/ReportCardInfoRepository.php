<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\CardWorkflow;
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
	 * Get Monthly Report List
	 * 
	 * @param  int    $corporateId Subsidiary Id
	 * @param  int    $projectId   Project Id
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function monthlyList(int $corporateId, ?int $projectId)
	{
		return $this->cardObj->where(function($query) use($projectId){

					$query->whereHas('project',function($query) use($projectId){
						$query->whereHas('manager',function($query){
							$query->where('profile_id',$this->profile->id);
						});
						$query->when($projectId, function ($query, $projectId) {
			                return $query->where('id', $projectId);
			            });
					});

					$query->orWhere('need_action',$this->profile->id);

				})->component()
				->paginate();
	}

	/**
	 * Get Weekly Report List
	 * 
	 * @param  int    $corporateId Subsidiary Id
	 * @param  int    $projectId   Project Id
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function weeklyList(int $corporateId, ?int $projectId)
	{
		return $this->reportObj->where(function($query) use($projectId){

					$query->whereHas('project',function($query) use($projectId){
						$query->whereHas('manager',function($query){
							$query->where('profile_id',$this->profile->id);
						});
						$query->when($projectId, function ($query, $projectId) {
			                return $query->where('id', $projectId);
			            });
					});

					$query->orWhere('need_action',$this->profile->id);

				})->component()
				->paginate();
	}


	/**
	 * Monthly Report Workflow
	 * 
	 * @param  int    	$corporateId 	Corporate Id
	 * @param  int    	$projectId   	Project Id
	 * @param  string   $dateStart   	Report Date Start
	 * @param  string   $dateEnd   		Report Date End
	 * @return Collection
	 */
	public function monthlyWorkflow(int $corporateId, int $projectId, string $dateStart, string $dateEnd)
	{
		return collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$projectId,$dateStart,$dateEnd){

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
				'monthly' => CardWorkflow::whereHas('card',function($query) use($projectId,$dateStart,$dateEnd){
								$query->where('project_id',$projectId);
								$query->whereDate('card_date',$dateStart );
								$query->whereDate('card_end', $dateEnd );
							})->where('state',$status)->with('card')->first(),
				'profile' => $profile
			];
		});
	}

	/**
	 * Weekly Report Workflow
	 * 
	 * @param  int    	$corporateId 	Corporate Id
	 * @param  int    	$projectId   	Project Id
	 * @param  string   $dateStart   	Report Date Start
	 * @param  string   $dateEnd   		Report Date End
	 * @return Collection
	 */
	public function weeklyWorkflow(int $corporateId, int $projectId, string $dateStart, string $dateEnd)
	{
		return collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$projectId,$dateStart,$dateEnd){

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
				'weekly' => ReportWorkflow::whereHas('report',function($query) use($projectId,$dateStart,$dateEnd){
								$query->where('project_id',$projectId);
								$query->whereDate('report_date',$dateStart );
								$query->whereDate('report_end', $dateEnd );
							})->where('state',$status)->with('report')->first(),
				'profile' => $profile
			];
		});
	}


	/**
	 * List All Profile Involve In Project 
	 * 
	 * @param  Collection 	$profile 	Profile
	 * @param  int 			$projectId 	Project Id
	 * @return Collection
	 */
	public function reportWorkflow(Collection $profile, int $projectId)
	{
		return collect(config('joesama/project::workflow.1'))->mapWithKeys(function($role,$state) use($profile,$projectId){

			$status = strtolower(MasterData::find($state)->description);

			$assignee = $profile->where('pivot.role_id',$role)->first();

			$role = collect(data_get($assignee,'role'))->where('pivot.project_id',$projectId)->first();

			return [
				$status => [ 
					'profile' => $assignee,
					'role' => $role
				]
			];
		});
	}

} // END class ReportCardInfoRepository 