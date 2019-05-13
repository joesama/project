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

	/**
	 * Calculate week different
	 * 
	 * @param  [type] $startDate [description]
	 * @param  [type] $endDate   [description]
	 * @return [type]            [description]
	 */
	public function calculateWeek($startDate, $endDate)
	{
		return $startDate->clone()->addWeek()->diffInWeeks($endDate->clone()->startOfWeek());
	}

	/**
	 * Calculate month different
	 * 
	 * @param  [type] $startDate [description]
	 * @param  [type] $endDate   [description]
	 * @return [type]            [description]
	 */
	public function calculateMonth($startDate, $endDate)
	{
		return $startDate->clone()->addMonth()->diffInMonths($endDate->clone()->startOfMonth());
	}

	/**
	 * Create Amount Formate to nearest billion
	 * 
	 * @param  $sumValue
	 * @return string
	 */
	public function shortHandFormat($sumValue): string 
	{
		if ($sumValue < 1000000000) {
		    // Anything less than a billion
		    $unit = 'M';
		    $amount = round($sumValue / 1000000,2);
		} else {
		    $unit = 'B';
		    $amount = round($sumValue / 1000000000,2);
		}

		return number_format($amount,2).''.$unit;
	}

}