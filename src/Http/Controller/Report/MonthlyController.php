<?php
namespace Joesama\Project\Http\Controller\Report;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Monthly Report Controller
 */
class MonthlyController extends BaseController
{
	/**
	 * Controller for weekly report
	 * 
	 * @param  Request $request     HTTP Request
	 * @param  int     $corporateId Corporate Id
	 * @param  	       $projectId   Project Id
	 * @return view                 View
	 */
	public function __invoke(Request $request, int $corporateId, $projectId )
	{
		parent::__construct($request);
		
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId,$projectId)
		);
	}
} // END class ClientController  