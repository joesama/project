<?php
namespace Joesama\Project\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class ProjectController extends BaseController
{


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function __invoke(Request $request, $corporateId)
	{

		$page = data_get($this->config,'page');

		set_meta('title',__($this->domain.'.'.$page));

		return view(
			$this->domain.'.'.$page,
			app($this->processor)->$page($request,$corporateId)
		);
	}




	/**
	 * Return Project Information
	 *
	 * @param string $part
	 * @param int $projectId
	 **/
	public function projectInformation(string $part, int $projectId)
	{
		\Cache::forget('project'.$part.$projectId);
		$page = $part;
		$part = (in_array($part, ['physical','financial'])) ? 'scurve' : $part;
		$component = \Cache::remember('project'.$page.$projectId, 60, function () use($projectId,$part){
			return collect(config('joesama/project::project.'.$part))
			->when($part == 'info', function ($collection) use($projectId){
			    return $collection->where('id',$projectId)->first();
			})->when($part != 'info', function ($collection) use($projectId){
			    return $collection->where('project_id',$projectId);
			});
		});


		return view('joesama/project::project.part.'.$page,[
			'projectPart' => $page,
			'projectId' => $projectId,
			'component' => $component
		]);
	}

} // END class ProjectController 
