<?php
namespace Joesama\Project\Http\Traits;

use Carbon\Carbon;

trait EffectiveDays {
	
	public function nonWeekendCount($startDate, $endDate, $holidays = []) {

		$startDate = ($startDate instanceof Carbon) ? $startDate : Carbon::parse($startDate);
		$endDate = ($endDate instanceof Carbon) ? $endDate : Carbon::parse($endDate);

		return $startDate->diffInDaysFiltered(function(Carbon $date) {
		   return !$date->isWeekend();
		}, $endDate);

	}

}