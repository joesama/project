<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;
use Joesama\Project\Database\Model\Organization\Profile;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class DashboardController 
{

	/**
	 * Return Group Portfolio
	 *
	 * @return void
	 * @author 
	 **/
	public function projectPorfolio()
	{

		$profile = Profile::where('user_id',auth()->id())->first();

		if($profile->corporate_id == 1){
			return redirect(handles('joesama/project::dashboard/portfolio/master/'. $profile->corporate_id));
		}else{
			return redirect(handles('joesama/project::dashboard/portfolio/group/'. $profile->corporate_id));
		}
	}

	/**
	 * Return Sub Portfolio
	 *
	 * @return void
	 * @author 
	 **/
	public function projectSubs()
	{
		return view('joesama/project::project.subsidiary');
	}

	/**
	 * Return Project Information
	 *
	 * @return void
	 * @author joharijumali@gmail.com
	 **/
	public function projectDashboard()
	{
		\Cache::forget('listproject');
		$project = \Cache::remember('listproject', 60, function () {
		    return config('joesama/project::project.info');
		});

		return view('joesama/project::project.overall',[
			'project' => $project
		]);
	}

} // END class ProjectController 
