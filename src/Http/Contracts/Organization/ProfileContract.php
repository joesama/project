<?php
namespace Joesama\Project\Http\Contracts\Organization;

/**
 * Business Need For Profile Info
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
interface ProfileContract
{
	/**
	 * A Project Should Have Milestone
	 * @param int $idProfile - Id For Profile
	 **/
	public function profileInfo(int $idProfile)
	{
	}
	
} // END interface CorporateContract