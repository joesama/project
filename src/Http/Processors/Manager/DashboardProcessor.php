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
			'tableProject' => $this->listProcessor->project($request,$corporateId),
			'tableTask' => $this->listProcessor->task($request,$corporateId),
			'tableIssue' => $this->listProcessor->issue($request,$corporateId),
			'tableRisk' => $this->listProcessor->risk($request,$corporateId),
		];
	}

} // END class MakeProjectProcessor 