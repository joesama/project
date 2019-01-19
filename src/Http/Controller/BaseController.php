<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;

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

		$this->view = $this->domain.'.'.$this->page;

		if(!view()->exists($this->view)){
			$page = ($this->module == 'manager' && !is_null($request->segment(5))) ? 'project-'.$this->page : $this->page;

			$this->view = 'joesama/project::components.'.$page;
		}

		Cache::forget($this->component);//@TODO remove for deploy
		$this->config = Cache::remember(
			$this->component, 60, function () {
		    return collect(config('joesama/project::policy.web.'.$this->component));
		});

		Cache::forget('profile-'.auth()->id());
		
		$profile = Cache::remember(
			'profile-'.auth()->id(), 60, function () {
		    return Profile::where('user_id',auth()->id())->with('role')->first();
		});

	}

} // END class BaseController 
