<?php
namespace Joesama\Project\Http\Controller\Project;

use App\Http\Controllers\Controller;

/**
 * Project Information Class
 *
 * @package joesama/project
 * @author joharijumali@gmail.com
 **/
class ProjectController extends Controller
{
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
