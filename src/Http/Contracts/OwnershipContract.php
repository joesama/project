<?php
namespace Joesama\Project\Http\Contracts;

/**
 * Business Need For Ownership
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
interface OwnershipContract
{

	/**
	 * A Project Should Have Basic Info
	 * @param int $idProject - Id For Project
	 **/
	public function projectMember(int $idProject)
	{
	}	

} // END interface OwnershipContract