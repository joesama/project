<?php
namespace Joesama\Project\Http\Controller\Report;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Weekly Report Controller
 */
class WeeklyController extends BaseController
{
	/**
	 * Controller for weekly report
	 * 
	 * @param  Request $request     HTTP Request
	 * @param  int     $corporateId Corporate Id
	 * @param  int     $projectId   Project Id
	 * @return view                 View
	 */
	public function __invoke(Request $request, int $corporateId, $projectId = null)
	{
		parent::__construct($request);
		
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		if($request->is('*/redirect/*')){
			return 	app($this->processor)->$page($request,$corporateId,$projectId);
		}

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId,$projectId)
		);
	}
} // END class ClientController  