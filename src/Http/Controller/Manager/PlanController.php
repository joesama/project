<?php
namespace Joesama\Project\Http\Controller\Manager;

use Illuminate\Http\Request;
use Joesama\Project\Http\Controller\BaseController;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Task Controller
 */
class PlanController extends BaseController
{
	/**
	 * Main Controller For Sub Module
	 **/
	public function __invoke(Request $request, $corporateId)
	{
		parent::__construct($request);
		
		set_meta('title',__($this->domain.'.'.$this->page));

		$page = $this->page;

		if(in_array($page,['view']) && is_null($request->segment(6))){

			$task = app(ProjectInfoRepository::class)->projectPlan($request->segment(5));

			return  redirect(handles($this->module.'/'.$this->submodule.'/'.$this->page.'/'.$corporateId.'/'.data_get($task,'project_id').'/'.$request->segment(5)));
		}

		return view(
			$this->view ,
			app($this->processor)->$page($request,$corporateId)
		);
	}
} // END class TaskController  