<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Http\Processors\Manager\ListProcessor;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class ProjectProcessor 
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
		$table = $this->listProcessor->project($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->issue($request,$corporateId);
		
		return compact('$table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->issue($request,$corporateId);
		
		return compact('$table');
	}

} // END class MakeProjectProcessor 