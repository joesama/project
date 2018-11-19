<?php
namespace Joesama\Project\Http\Contracts;
/**
 * Business Need For Project
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
interface ProjectContract
{

	/**
	 * A Project Should Have Basic Info
	 * @param int $idProject - Id For Project
	 **/
	public function projectInfo(int $idProject)
	{
	}

	/**
	 * A Project Should Have Client
	 * @param int $idProject - Id For Project
	 **/
	public function projectClient(int $idProject)
	{
	}

	/**
	 * A Project Should Have Member
	 * @param int $idProject - Id For Project
	 **/
	public function projectMember(int $idProject)
	{
	}

	/**
	 * A Project Should Have Task
	 * @param int $idProject - Id For Project
	 **/
	public function projectTask(int $idProject)
	{
	}

	/**
	 * A Project Task Should Have Progress
	 * @param int $idProject - Id For Project
	 * @param int $idTask - Id For Task Is Specified. By Default Null
	 **/
	public function projectProgress(int $idProject, int $idTask = NULL )
	{
	}

	/**
	 * A Project Should Have Budget/Costing
	 * @param int $idProject - Id For Project
	 **/
	public function projectCosting(int $idProject)
	{
	}

} // END interface ProjectContract