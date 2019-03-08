<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Setup\ProcessRepository;

/**
 * Processing All FLow Process 
 *
 * @package default
 * @author 
 **/
class FlowProcessor 
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
	public function save(Request $request,int $corporateId, ?int $flowId)
	{
		$task = $this->processRepository->saveFlow(collect($request->all()), $corporateId, $flowId);

		return redirect_with_message(
			handles('setup/flow/list/'.$corporateId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::setup.flow.form')
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
		return $this->processRepository->deleteFlowAndSteps($flowId);
	}


} // END class MakeProjectProcessor 