<?php
namespace Joesama\Project\Http\Controller\Manager;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;

/**
 * Task Controller
 */
class HseController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		parent::__construct($request);
		
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId)
		);
	}
} // END class AtrributeController  