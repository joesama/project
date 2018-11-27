<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class ProjectController extends BaseController
{
	/**
	 * Return Project Information
	 *
	 * @param string $part
	 * @param int $projectId
	 **/
	public function projectInformation(string $part, int $projectId)
	{

		return view('joesama/project::project.part.'.$part,[
			'projectPart' => $part,
			'projectId' => $projectId
		]);
	}

} // END class ProjectController 
