<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Setup\ProcessRepository;

/**
 * Processing All Flow Steps 
 *
 * @package default
 * @author 
 **/
class StepProcessor 
{
	/**
	 * Repository To Process All Flow & Steps 
	 * @var void
	 */
	private $processRepository;

	public function __construct(
		ProcessRepository $repo
	){
		$this->processRepository = $repo;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  ?int $flowId
	 * @return 
	 */
	public function save(Request $request,int $corporateId, int $flowId, ?int $stepId = null)
	{
		$task = $this->processRepository->saveStep(collect($request->all()), $corporateId, $flowId, $stepId);

		return redirect_with_message(
			handles('setup/step/list/'.$corporateId.'/'.$flowId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::setup.step.form')
			]),
            'success'
		);
	}

	/**
	 * Remove step from flow
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $flowId)
	{
		return $this->processRepository->deleteStep($flowId,$request->segment(6));
	}


} // END class MakeProjectProcessor 