<?php
namespace Joesama\Project\Database\Repositories\Dashboard; 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Project\Issue;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Task;

class MasterRepository 
{
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
			        })->where('active',1)->count(),

			'closed' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->where('active',0)->count(),

			'ontrack' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->onTrack()->count(),

			'delayed' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->delayed()->count(),

			'total' => Project::when($corporateId, function ($query, $corporateId) {
				            return $query->sameGroup($corporateId);
				        })->count()
		]);

	}

	/**
	 * Summarize Contract Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectContract(int $corporateId = null)
	{
		$sumValue = Project::when($corporateId, function ($query, $corporateId) {
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

		$chart = Project::when($corporateId, function ($query, $corporateId) {
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

} // END class FinancialRepository 