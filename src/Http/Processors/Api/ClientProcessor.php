<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MakeProjectRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class ClientProcessor 
{

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MakeProjectRepository $makeProject
	){
		$this->projectObj = $projectInfo;
		$this->makeProject = $makeProject;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId, int $clientId = null)
	{
		$task = $this->makeProject->initClient(collect($request->all()),$clientId);

		return redirect_with_message(
			handles('corporate/'.$request->segment(2).'/list/'.$corporateId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::corporate.'.$request->segment(2).'.form')
			]),
            'success'
		);
	}


} // END class MakeProjectProcessor 