<?php
namespace Joesama\Project\Http\Contracts\Project;

/**
 * Business Need For Ownership
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
interface JobContract
{

	/**
	 * A Project Should Have Milestone
	 * @param int $idProject - Id For Project
	 **/
	public function projectMilestone(int $idProject)
	{
	}

	/**
	 * A Project Will Have Tasking / Job To Do 
	 * @param int $idProject - Id For Project
	 **/
	public function projectTask(int $idProject)
	{
	}
	

} // END interface JobContract