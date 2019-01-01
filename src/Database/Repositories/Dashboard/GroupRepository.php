<?php
namespace Joesama\Project\Database\Repositories\Dashboard; 

use Joesama\Project\Database\Model\Organization\Corporate;

class GroupRepository
{
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function subsidiaries()
	{
		return Corporate::all();
	}

} // END class GroupRepository 