<?php
namespace Joesama\Project\Http\Controller\Setup;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Steps Controller
 */
class StepController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId)
		);
	}
} // END class StepsController  