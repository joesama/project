<?php
namespace Joesama\Project\Http\Controller\Manager;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;

/**
 * Dashboard Controller
 */
class ProjectController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->domain.'.'.$this->page,
			app($this->processor)->$page($request,$corporateId)
		);
	}
} // END class ProjectController  