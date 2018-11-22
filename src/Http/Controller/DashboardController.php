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
	 * Return Group Portfolio
	 *
	 * @return void
	 * @author 
	 **/
	public function projectPorfolio()
	{
		return view('joesama/project::project.portfolio');
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
		return view('joesama/project::project.overall');
	}

} // END class ProjectController 
