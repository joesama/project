<?php
namespace Joesama\Project\Http\Controller\Dashboard;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * PortfolioController
 */
class PortfolioController extends BaseController
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
} // END class PortfolioController  