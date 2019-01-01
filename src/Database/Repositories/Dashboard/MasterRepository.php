<?php
namespace Joesama\Project\Database\Repositories\Dashboard; 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Project\Project;

class MasterRepository 
{
	/**
	 * Summarize Project Info
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectSummary(int $corporateId = null)
	{

		$project = collect([
			'active' => Project::where('active',1)->count(),
			'closed' => Project::where('active',0)->count(),
			'ontrack' => Project::onTrack()->count(),
			'delayed' => Project::delayed()->count(),
			'total' => Project::count()
		]);

		return compact('project');
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
		    $format = number_format($number / 1000000, 2);
		} else {
		    $unit = 'B';
		    $format = number_format($number / 1000000000, 2);
		}

		$contract = collect([
			'total' => [
				'value' => $format,
				'unit' => $unit
			]
		]);

		return compact('contract');
	}

} // END class FinancialRepository 