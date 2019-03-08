<?php
namespace Joesama\Project\Database\Repositories\Setup; 

use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Process\Flow;
use Joesama\Project\Database\Model\Process\Step;


class ProcessRepository 
{
	/**
	 * Model for flow data processing
	 * 
	 * @var Joesama\Project\Database\Model\Process\Flow
	 */
	private $flowModel;

	/**
	 * Model for steps data processing
	 * 
	 * @var Joesama\Project\Database\Model\Process\Step
	 */
	private $stepModel;

	/**
	 * Define all dependency to class
	 * 
	 * @param Flow $flowObj Flow Model
	 * @param Step $stepObj Step Model
	 */
	public function __construct(Flow $flowObj, Step $stepObj)
	{
		$this->flowModel = $flowObj;

		$this->stepModel = $stepObj;
	}

	/**
	 * Get All Process Flow For Respected Corporation
	 * 
	 * @param  int    $corporationId [description]
	 * @return [type]                [description]
	 */
	public function getAllFlowByCorporation( int $corporationId )
	{
		return $this->flowModel->sameGroup($corporationId)->paginate();
	}

	/**
	 * Get All Process Steps For Respected Flow
	 * 
	 * @param  int    $corporationId Corporation ID
	 * @param  int    $flowId Flow Id
	 * @return [type]                [description]
	 */
	public function getFlowSteps(int $flowId )
	{
		return $this->stepModel->where('process_flow_id',$flowId)->paginate();
	}

	/**
	 * Register New Flow Base On Corporate Id
	 * 
	 * @param  Request $request     
	 * @param  int     $corporateId Corporate Id
	 * @param  int     $flowId      Flow Id
	 * @return 
	 */
	public function saveFlow(Collection $request, int $corporateId, ?int $flowId)
	{
		if($flowId !== null)
		{
			$this->flowModel =  $this->flowModel->find($flowId);
		}
		else{

			$this->flowModel->corporate_id = $corporateId;

			$this->flowModel->created_by = \Auth()->id();
		}

		$this->flowModel->label = $request->get('label');

		$this->flowModel->description = $request->get('description');

		$this->flowModel->save();
	}

	/**
	 * Delete Step Data For Specific Step Id
	 * 
	 * @param  int     $flowId      Flow Id
	 * @param  int     $stepId      Step Id
	 * @return 
	 */
	public function deleteFlowAndSteps(int $flowId)
	{
		$flow = $this->flowModel->find($flowId);

		$flow->steps()->delete();

		$flow->delete();
	}

	/**
	 * Save Step Data For Specific Flow Process
	 * 
	 * @param  Request $request     
	 * @param  int     $corporateId Corporate Id
	 * @param  int     $flowId      Flow Id
	 * @param  int     $stepId      Step Id
	 * @return 
	 */
	public function saveStep(Collection $request, int $corporateId, int $flowId, ?int $stepId)
	{
		if($stepId !== null)
		{
			$this->stepModel =  $this->stepModel->find($stepId);
		}
		else{

			$this->stepModel->process_flow_id = $flowId;

			$this->stepModel->created_by = \Auth()->id();
		}

		$this->stepModel->label = $request->get('label');

		$this->stepModel->description = $request->get('description');

		$this->stepModel->save();
	}

	/**
	 * Delete Step Data For Specific Step Id
	 * 
	 * @param  int     $flowId      Flow Id
	 * @param  int     $stepId      Step Id
	 * @return 
	 */
	public function deleteStep(int $flowId, int $stepId)
	{
		$this->stepModel->where('id' , $stepId)->where('process_flow_id', $flowId)->delete();
	}

} // END class ProcessRepository 