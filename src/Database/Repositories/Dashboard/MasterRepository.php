<?php
namespace Joesama\Project\Database\Repositories\Dashboard; 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Project\Issue;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Task;
use Joesama\Project\Http\Traits\EffectiveDays;

class MasterRepository 
{
	use EffectiveDays;

	/**
	 * Summarize Project Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectSummary(int $corporateId = null)
	{
		return collect([
			'active' => Project::when($corporateId, function ($query, $corporateId) {
			            return $query->sameGroup($corporateId);
			        })->active()->count(),

			'closed' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->notActive()->count(),

			'ontrack' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->onTrack()->count(),

			'delayed' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->delayed()->count(),

			'total' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->wasApproved()->count()
		]);

	}

	/**
	 * Summarize Contract Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectContract(int $corporateId = null)
	{
		$sumValue = Project::active()->when($corporateId, function ($query, $corporateId) {
            return $query->sameGroup($corporateId);
        })->sum('value');

		if ($sumValue < 1000000000) {
		    // Anything less than a billion
		    $unit = 'M';
		    $format = round($sumValue / 1000000,2);
		} else {
		    $unit = 'B';
		    $format = round($sumValue / 1000000000,2);
		}

		$chart = Project::active()->when($corporateId, function ($query, $corporateId) {
	            return $query->sameGroup($corporateId);
	        })->pluck('value','id')->map(function($item,$key){
	        	return [ $key,(is_null($item) ? 0 : $item)] ;
 	        })->values()->toArray();

		return  collect([
			'total' => [
				'value' => $format,
				'unit' => $unit
			],
			'chartData' => $chart
		]);

	}

	/**
	 * Summarize Issue Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectTask(int $corporateId = null)
	{
		return collect([
			'total' => Task::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->count(),

			'complete' => Task::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->complete()->count(),

			'overdue' => Task::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->overdue()->count()
		]);

	}

	/**
	 * Summarize Issue Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectIssue(int $corporateId = null)
	{
		return collect([
			'open' => Issue::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->open()->count(),

			'complete' => Issue::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->complete()->count(),

			'total' => Issue::when($corporateId, function ($query, $corporateId) {
		            return $query->whereHas('project',function($query) use($corporateId){
						$query->sameGroup($corporateId);
					});
		        })->count()
		]);

	}

	/**
	 * Retrieve Project Costing
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function projectProgress(int $corporateId = null)
	{
		$projectDuration = collect([]);
		$actualProgress = collect([]);
		$plannedProgess = collect([]);

		Project::when($corporateId, function ($query, $corporateId) {
            return $query->sameGroup($corporateId);
        })->where('active',1)->orderBy('created_at')->get()
        ->each(function($project) use($projectDuration,$actualProgress,$plannedProgess){

        	$duration = data_get($project,'effective_days');

        	if(intval($duration) == 0){
        		$duration = $this->nonWeekendCount(data_get($project,'start'),data_get($project,'end'));
        	}

        	$planned = data_get($project,'planned_progress');
        	$actual = data_get($project,'actual_progress');

        	$projectDuration->push($duration);
        	$plannedProgess->push($duration*$planned);
        	$actualProgress->push($duration*$actual);

        });

        $sumProjectDuration = $projectDuration->sum();
        $sumPlannedProgress = $plannedProgess->sum();
        $sumActualProgress = $actualProgress->sum();

		return collect([
			'planned' => ($sumProjectDuration > 0) ? round($sumPlannedProgress/$sumProjectDuration,2) : 0,
			'actual' => ($sumProjectDuration > 0) ? round($sumActualProgress/$sumProjectDuration,2) : 0,
		]);
	}

	/**
	 * Retrieve Project Costing
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function projectCosting(int $corporateId = null)
	{
		$planned = collect([]);
		$actual = collect([]);

		Project::when($corporateId, function ($query, $corporateId) {
            return $query->sameGroup($corporateId);
        })->where('active',1)->orderBy('created_at')->get()->map(function($project){

        	$claim = collect(data_get($project,'payment'))->mapWithKeys(function ($item) {
			    return [$item['claim_date'] => $item['claim_amount']];
			});

        	$paid = collect(data_get($project,'payment'))->mapWithKeys(function ($item) {
			    return [$item['claim_date'] => $item->sum('paid_amount')];
			});

        	return collect([
        		'project' => str_limit(data_get($project,'name'),20,'...'),
        		'planned' => $claim,
        		'actual' => $paid
        	]);
        })->each(function($payment) use($planned,$actual){

        	data_get($payment,'planned')->each(function($value,$date) use ($planned){

        		$previous = collect($planned->get($date))->get('planned');

        		$planned->put($date, [
        			'period' => $date,
        			'planned' => $previous + $value,
        			'actual' => 0,
        		]);
        	});

        	data_get($payment,'actual')->each(function($value,$date) use ($planned){

        		$previous = collect($planned->get($date))->get('actual');
        		$plannedVal = collect($planned->get($date))->get('planned');

        		$planned->put($date, [
        			'period' => $date,
        			'planned' => $plannedVal,
        			'actual' => $previous + $value,
        		]);

        	});
        });

		return $planned->values();
	}

	/**
	 * Retrieve Project Costing
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function projectVariance(int $corporateId = null)
	{
		$costing = collect([]);

		Project::when($corporateId, function ($query, $corporateId) {
            return $query->sameGroup($corporateId);
        })->where('active',1)->orderBy('created_at')->get()->each(function($project) use($costing){
        	$costing->push([
        		'project' => str_limit(data_get($project,'name'),20,'...'),
        		'variance' => data_get($project,'variance')
        	]);
        });

		return $costing;
	}

	/**
	 * Retrieve Project Overdue Task
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function perProjectTask(int $corporateId = null)
	{
		$task = collect([]);

		Task::when($corporateId, function ($query, $corporateId) {
            return $query->whereHas('project',function($query) use($corporateId){
				$query->sameGroup($corporateId);
			});
        })->overdue()->with('project')->get()->groupBy('project_id')->each(function($projectTask) use($task){

        	$task->push([
        		'label' => str_limit(data_get($projectTask->first(),'project.name'),20,'...'),
        		'value' => $projectTask->count()
        	]);

        });

        return $task;
	}

	/**
	 * Retrieve Project Open Issues
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function perProjectIssue(int $corporateId = null)
	{
		$issue = collect([]);

		Issue::when($corporateId, function ($query, $corporateId) {
            return $query->whereHas('project',function($query) use($corporateId){
				$query->sameGroup($corporateId);
			});
        })->open()->with('project')->get()->groupBy('project_id')->each(function($projectIssue) use($issue){

        	$issue->push([
        		'label' => str_limit(data_get($projectIssue->first(),'project.name'),20,'...'),
        		'value' => $projectIssue->count()
        	]);

        });

        return $issue;
	}

	/**
	 * Retrieve Project Health
	 * @param  int|null $corporateId
	 * @return Collection
	 */
	public function projectHealth(int $corporateId = null)
	{
		$health = collect([]);

		Project::when($corporateId, function ($query, $corporateId) {
            return $query->sameGroup($corporateId);
        })->where('active',1)->get()->each(function($project) use($health){
        	$health->push([
        		'id' => data_get($project,'id'),
        		'name' => data_get($project,'name'),
        		'condition' => $this->calcHealth(data_get($project,'planned_progress'),data_get($project,'actual_progress')) 
        	]);
        });

		return $health->sortByDesc('id');
	}

	/**
	 * calculate health variance
	 * @param  float  $planned Planned Progress
	 * @param  float  $actual  Actual Progress
	 * @return int - refer to master config
	 */
	protected function calcHealth(float $planned, float $actual)
	{
		$difference = $planned - $actual;

		if($difference <= 5){
			return 1;
		}

		if($difference <= 10 && $difference > 5){
			return 2;
		}

		if($difference > 10){
			return 3;
		}

	}


	/**
	 * Return All Subsidiaries
	 * @return Collection
	 */
	public function subsidiaries()
	{
		return Corporate::all();
	}

} // END class FinancialRepository 