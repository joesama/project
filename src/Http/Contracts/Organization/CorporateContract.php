<?php
namespace Joesama\Project\Http\Contracts\Organization;

/**
 * Business Need For Corporate Info
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
interface CorporateContract
{
	/**
	 * A Project Should Have Milestone
	 * @param int $idCorporate - Id For Corporate
	 **/
	public function corporateInfo(int $idCorporate)
	{
	}

} // END interface CorporateContract