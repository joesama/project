<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Http\Processors\Manager\ListProcessor;

/**
 * Risk Record 
 *
 * @package default
 * @author 
 **/
class RiskProcessor 
{

	public function __construct(
		ListProcessor $listProcessor
	){
		$this->listProcessor = $listProcessor;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->risk($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->risk($request,$corporateId);
		
		return compact('$table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->risk($request,$corporateId);
		
		return compact('$table');
	}

} // END class MakeProjectProcessor 