<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class BaseController extends Controller
{
	protected $config, $module, $submodule, $domain, $processor;

	public function __construct(Request $request)
	{
		$this->module = $request->segment(1);
		$this->submodule = $request->segment(2);
		$this->page = $request->segment(3);
		$this->component = $this->module . '.' . $this->submodule;
		$this->domain = 'joesama/project::'.$this->component;
		

		$this->processor = 'Joesama\Project\Http\Processors\\'
							.ucfirst($this->module).'\\'
							.ucfirst($this->submodule)
							.'Processor';

		Cache::forget($this->component);//@TODO remove for deploy
		$this->config = Cache::remember(
			$this->component, 60, function () {
		    return collect(config('joesama/project::policy.web.'.$this->component));
		});
	}

} // END class BaseController 
