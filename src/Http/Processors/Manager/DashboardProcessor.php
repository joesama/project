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
			'tableWeekly' => $this->listProcessor->weeklyReport($request,$corporateId),
			'tableMonthly' => $this->listProcessor->monthlyReport($request,$corporateId),
			'tableApproval' => $this->listProcessor->projectApproval($request,$corporateId)
		];
	}

} // END class MakeProjectProcessor 