<?php
namespace Joesama\Project\Http\Controller\Api;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;

/**
 * ApiController
 */
class ApiController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		$page = strstr($this->page,'-',true);
		$page = ($page == false) ?  $this->page : $page;

		return app($this->processor)->$page($request,$corporateId,$request->segment(5));
	}
} // END class DashboardController  