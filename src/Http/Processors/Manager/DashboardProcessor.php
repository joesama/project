<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Joesama\Project\Http\Processors\Manager\ListProcessor;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class DashboardProcessor 
{

	public function __construct(
		ListProcessor $listProcessor
	){
		$this->listProcessor = $listProcessor;
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