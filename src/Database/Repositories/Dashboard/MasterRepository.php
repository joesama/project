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
			'active' => Project::where('active',1)->count(),
			'closed' => Project::where('active',0)->count(),
			'ontrack' => Project::onTrack()->count(),
			'delayed' => Project::delayed()->count(),
			'total' => Project::count()
		]);
	}

	/**
	 * Summarize Contract Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectContract(int $corporateId = null)
	{
		$sumValue = Project::sum('value');

		if ($sumValue < 1000000000) {
		    // Anything less than a billion
		    $unit = 'M';
		    $format = round($sumValue / 1000000,2);
		} else {
		    $unit = 'B';
		    $format = round($sumValue / 1000000000,2);
		}

		$chart = Project::pluck('value','id')->map(function($item,$key){
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
		$builder = Task::when($corporateId, function ($query, $corporateId) {
            return $query->whereHas('project',function($query) use($corporateId){
				$query->sameGroup($corporateId);
			});
        });

        $total = $builder->count();
        $overdue = $builder->overdue()->count();
        $complete = $builder->complete()->count();

		return collect([
			'total' => $total,
			'complete' => $complete,
			'overdue' => $overdue
		]);

	}

	/**
	 * Summarize Issue Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectIssue(int $corporateId = null)
	{
		$builder = Issue::when($corporateId, function ($query, $corporateId) {
            return $query->whereHas('project',function($query) use($corporateId){
				$query->sameGroup($corporateId);
			});
        });

		return collect([
			'open' => $builder->open()->count(),
			'complete' => $builder->complete()->count(),
			'total' => $builder->count()
		]);

	}

} // END class FinancialRepository 