<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class BaseController 
{

	function __construct()
	{
		$this->project = \Cache::remember('project', 60, function () {
		    return config('joesama/project::project');
		});
	}

} // END class BaseController 
