<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class DashboardController 
{
	/**
	 * Return Project Information
	 *
	 * @return void
	 * @author joharijumali@gmail.com
	 **/
	public function projectDashboard()
	{
		return view('joesama/project::project.overall');
	}

} // END class ProjectController 
