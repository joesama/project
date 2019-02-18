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
use Joesama\Project\Database\Model\Project\TagMilestone;


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
	 * Get Monthly Report Information
	 * 
	 * @param  int    $reportId Report Id
	 * @return Joesama\Project\Database\Model\Project\Card
	 */
	public function getMonthlyReportInfo(int $reportId)
	{
		return Card::where('id',$reportId)->component()->first();
	}

	/**
	 * Get Weekly Report Information
	 * 
	 * @param  int    $reportId Report Id
	 * @return Joesama\Project\Database\Model\Project\Report
	 */
	public function getWeeklyReportInfo(int $reportId)
	{
		return Report::where('id',$reportId)->component()->first();
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
		$isHistory = (request()->segment(1) == 'report' && request()->segment(3) == 'list') ? true : false;

		return $this->cardObj->where(function($query) use($projectId, $isHistory){
					$query->when($isHistory, function ($query, $isHistory)  use($projectId){ 
						$query->whereHas('project',function($query) use($projectId){
							$query->whereHas('manager',function($query){
								$query->where('profile_id',$this->profile->id);
							})
							->orWhereHas('profile',function($query){
								$query->where('profile_id',$this->profile->id);
							});

							$query->when($projectId, function ($query, $projectId) {
				                return $query->where('id', $projectId);
				            });
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
		$isHistory = (request()->segment(1) == 'report' && request()->segment(3) == 'list') ? true : false;

		return $this->reportObj->where(function($query) use($projectId, $isHistory){
					$query->when($isHistory, function ($query, $isHistory) use($projectId){ 
						$query->whereHas('project',function($query) use($projectId){
							$query->whereHas('manager',function($query){
								$query->where('profile_id',$this->profile->id);
							})
							->orWhereHas('profile',function($query){
								$query->where('profile_id',$this->profile->id);
							});
							
							$query->when($projectId, function ($query, $projectId) {

				                return $query->where('id', $projectId);
				            });
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
	 * @param  string   $dateStart   	Report Date Start
	 * @param  string   $dateEnd   		Report Date End
	 * @param  Project  $project   		Project Model
	 * @return Collection
	 */
	public function monthlyWorkflow(int $corporateId, string $dateStart, string $dateEnd, $project)
	{
		return collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$dateStart,$dateEnd, $project){

			$status = strtolower(MasterData::find($state)->description);

			if (in_array($state,[1,2])) {
				$profile = $project->profile->where('corporate_id',$project->corporate_id)->where('pivot.role_id',$role)->first();
			} else {
				$profile = $project->profile->where('corporate_id',1)->where('pivot.role_id',$role)->first();
			}

			return [
				'status' => $status,
				'step' => $state,
				'monthly' => CardWorkflow::whereHas('card',function($query) use($project,$dateStart,$dateEnd){
								$query->where('project_id',$project->id);
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
	 * @param  string   $dateStart   	Report Date Start
	 * @param  string   $dateEnd   		Report Date End
	 * @param  Project  $project   		Project Model
	 * @return Collection
	 */
	public function weeklyWorkflow(int $corporateId, string $dateStart, string $dateEnd, $project)
	{
		return collect(config('joesama/project::workflow.1'))->map(function($role,$state) use($corporateId,$dateStart,$dateEnd, $project){

			$status = strtolower(MasterData::find($state)->description);

			if (in_array($state,[1,2])) {
				$profile = $project->profile->where('corporate_id',$project->corporate_id)->where('pivot.role_id',$role)->first();
			} else {
				$profile = $project->profile->where('corporate_id',1)->where('pivot.role_id',$role)->first();
			}

			return [
				'status' => $status,
				'step' => $state,
				'weekly' => ReportWorkflow::whereHas('report',function($query) use($project,$dateStart,$dateEnd){
								$query->where('project_id',$project->id);
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
	public function reportWorkflow($project, int $projectId)
	{
		return collect(config('joesama/project::workflow.1'))->mapWithKeys(function($role,$state) use($project,$projectId){

			$status = strtolower(MasterData::find($state)->description);

			if (in_array($state,[1,2])) {
				$profile = $project->profile->where('corporate_id',$project->corporate_id)->where('pivot.role_id',$role)->first();
			} else {
				$profile = $project->profile->where('corporate_id',1)->where('pivot.role_id',$role)->first();
			}
			
			$role = collect(data_get($profile,'role'))->where('pivot.project_id',$projectId)->first();

			return [
				$status => [ 
					'profile' => $profile,
					'role' => $role
				]
			];
		});
	}

	/**
	 * Schedule Payment
	 * 
	 * @param  Collection $payment  All Payment Schedule For Project
	 * @return Collection 
	 */
	public function scheduleTask(int $projectId)
	{

		$trasaction = collect([]);
		$task = TagMilestone::has('task')->with(['task' => function($query) use($projectId){
			$query->where('project_id',$projectId);
		}])->get()->mapWithKeys(function($item){
			return [$item['label'] => $item['task']];
		})->each(function($item,$key) use($trasaction){
			
			$sum = collect([]);
			$actual = collect([]);
			$plan = $item->sortBy(function ($task, $key) {
			    return Carbon::parse($task['end']);
			})->mapWithKeys(function ($item, $key) use($sum,$actual){
				$sum->push($item['planned_progress']);
				$actual->put(Carbon::parse($item['end'])->format('d-m-Y'),0);
			    return [ Carbon::parse($item['end'])->format('d-m-Y') => $sum->sum()];
			});

			

			$paidsum = collect([]);
			$actual->each(function ($val, $date) use($item,$paidsum,$actual){
				$amount = $item->where('end',Carbon::parse($date)->format('Y-m-d'))->sum('actual_progress');
				$paidsum->push($amount);
				$actual->put($date,$paidsum->sum());
			});

			
			$actualVariance = $actual->filter(function($alt,$key){
				return Carbon::parse($key) < Carbon::now();
			});

			$planVariance = $plan->filter(function($alt,$key){
				return Carbon::parse($key) < Carbon::now();
			});

			$variance = $actualVariance->sum() - $planVariance->sum();

			$plan->prepend('Planned');
			$actual->prepend('Actual');

			$latest = $planVariance->keys()->last();

			$trasaction->put($key,collect([
				'planned' => $plan->values(),
				'actual' => $actual->values(),
				'categories' => $plan->keys(),
				'variance' => $variance,
				'latest' => $latest,
			]));
		});

		return $trasaction;
	}

} // END class ReportCardInfoRepository 