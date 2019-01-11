<?php
namespace Joesama\Project\Http\Controller\Corporate;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;

/**
 * Corporate Profile Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class ProfileController extends BaseController
{

	/**
	 * Controller for profile information
	 * 
	 * @param  Request $request     HTTP Request
	 * @param  int     $corporateId Corporate Id
	 * @return view                 View
	 */
	public function __invoke(Request $request, int $corporateId)
	{
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId)
		);
	}

} // END class CorporateController 
