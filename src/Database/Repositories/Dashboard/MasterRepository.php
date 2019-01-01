<?php
namespace Joesama\Project\Database\Repositories\Dashboard; 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class MasterRepository 
{
	/**
	 * Summarize Project Info
	 * @param  Collection $project     Project Data Model
	 * @param  int|null   $corporateId Corporate Id
	 * @return Illuminate\Support\Collection
	 */
	public function projectSummary(Collection $project, int $corporateId = null)
	{
		$project = collect([
			'active' => $project->where('active',1)->count(),
			'closed' => $project->where('active',0)->count(),
			'ontrack' => $project->count(),
			'delayed' => $project->where('end','<',Carbon::now())->count(),
			'total' => $project->count()
		]);

		return compact('project');
	}

} // END class FinancialRepository 