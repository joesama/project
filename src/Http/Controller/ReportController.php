<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class ReportController extends BaseController
{
	/**
	 * Return Project Information
	 *
	 * @param string $part
	 * @param int $projectId
	 **/
	public function projectReport(int $projectId)
	{

		return view('joesama/project::project.report.list',[
			'projectId' => $projectId
		]);
	}

	/**
	 * Return Project Information
	 *
	 * @param string $part
	 * @param int $projectId
	 **/
	public function reportFormat(int $projectId)
	{

		return view('joesama/project::project.report.format',[
			'projectId' => $projectId
		]);
	}

} // END class ProjectController 
