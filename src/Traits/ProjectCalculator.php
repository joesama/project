<?php
namespace Joesama\Project\Traits;

use Carbon\Carbon;

trait ProjectCalculator{
	
	/**
	 * Calculate Effective Days
	 * 
	 * @param  string $start 	Date Start
	 * @param  string $end   	Date End
	 * @return int       		Number of days
	 */
	public function effectiveDays(string $start, string $end)
	{
		$startDate = Carbon::parse($start)->startOfDay();
		$endDate = Carbon::parse($end)->endOfDay();

		return $startDate->diffInDaysFiltered(function(Carbon $date) {
		   return !$date->isWeekend();
		}, $endDate);
	}

}