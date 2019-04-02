<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class DashboardProcessor 
{
	use HasAccessAs;

	public function __construct(
		ListProcessor $listProcessor
	){
		$this->listProcessor = $listProcessor;
		$this->profile();
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function overall($request,$corporateId)
	{

		return [
			'tableWeekly' => $this->listProcessor->weeklyReportHistory($request, $this->profile()->id),
			'tableMonthly' => $this->listProcessor->monthlyReportHistory($request, $this->profile()->id),
			'tableApproval' => $this->listProcessor->projectApproval($request,$corporateId)
		];
	}

} // END class MakeProjectProcessor 