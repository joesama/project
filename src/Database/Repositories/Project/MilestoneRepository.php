<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Project\FinanceMilestone;
use Joesama\Project\Database\Model\Project\FinanceProgress;
use Joesama\Project\Database\Model\Project\PhysicalMilestone;
use Joesama\Project\Database\Model\Project\PhysicalProgress;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\TagMilestone;


/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class MilestoneRepository 
{
	private $physicalObj, $financialObj;

	function __construct(
		PhysicalMilestone $physicalObj,
		FinanceMilestone $financialObj
	)
	{
		$this->physicalObj = $physicalObj;
		$this->financialObj = $financialObj;
	}


	/**
	 * Physical Progress List
	 * 
	 * @param  int    $corporateId [description]
	 * @param  int    $projectId   [description]
	 * @return Paginate
	 */
	public function physicalList(int $corporateId, int $projectId )
	{
		return $this->physicalObj->where('project_id',$projectId)->paginate();
	}

	/**
	 * Physical Progress List
	 * 
	 * @param  int    $corporateId [description]
	 * @param  int    $projectId   [description]
	 * @return Paginate
	 */
	public function financeList(int $corporateId, int $projectId )
	{
		return $this->financialObj->where('project_id',$projectId)->paginate();
	}

	/**
	 * Manage Progress Milestone
	 * 
	 * @param  Collection $request   	HTTP Request
	 * @param  int        $projectId 	Project Id
	 * @param  int|null   $milestoneId 	Milestone ID
	 * @return PhysicalMilestone
	 */
	public function physicalMilestone(Collection $request, int $projectId, ?int $milestoneId)
	{
		$inputData = collect($request)->intersectByKeys([
		    'planned' => 0,
		    'actual' => 0
		]);

		DB::beginTransaction();

		try{
			if(!is_null($milestoneId)){
				$this->physicalObj = $this->physicalObj->find($milestoneId);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					$this->physicalObj->{$field} = $record;
				}
			});

			if($milestoneId == null){
				$this->physicalObj->project_id = $projectId;
				$this->physicalObj->label = $request->get('label');
				$this->physicalObj->progress_date = Carbon::createFromFormat('d/m/Y',$request->get('progress_date'))->format('Y-m-d');

				$this->financialObj->project_id = $projectId;
				$this->financialObj->label = $request->get('label');
				$this->financialObj->progress_date = Carbon::createFromFormat('d/m/Y',$request->get('progress_date'))->format('Y-m-d');
				$this->financialObj->save();

			}
      
			$this->physicalObj->save();

			$projectValue = $this->physicalObj->project->value;

			$financial = $this->financialObj->where('project_id',$projectId)
											->where('progress_date',$this->physicalObj->progress_date)
											->first();

			$financial->planned = round(($this->physicalObj->planned/100)*$projectValue,2);

			$actual = $request->get('actual');

			if($actual != null){
				$actualAmount = round(($actual/100)*$projectValue,2);

				$financial->actual = $actualAmount;
			}

			$financial->save();

			if($actual != null){

				$this->physicalObj->progress()->save(new PhysicalProgress([
					'progress' => $this->physicalObj->planned
				]));

				$financial->progress()->save(new FinanceProgress([
					'progress' => $financial->actual
				]));

			}

			DB::commit();

			return $this->physicalObj;

		}catch( Exception $e){
			throw new Exception($e->getMessage(), 1);
			DB::rollback();
		}
	}

	/**
	 * Manage Progress Milestone
	 * 
	 * @param  Collection $request   	HTTP Request
	 * @param  int        $projectId 	Project Id
	 * @param  int|null   $milestoneId 	Milestone ID
	 * @return PhysicalMilestone
	 */
	public function financialMilestone(Collection $request, int $projectId, ?int $milestoneId)
	{
		$inputData = collect($request)->intersectByKeys([
		    'planned' => 0,
		    'actual' => 0
		]);

		DB::beginTransaction();

		try{

			if(!is_null($milestoneId)){
				$this->financialObj = $this->financialObj->find($milestoneId);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					$this->financialObj->{$field} = $record;
				}
			});

			$this->financialObj->save();

			DB::commit();

			return $this->financialObj;

		}catch( Exception $e){
			throw new Exception($e->getMessage(), 1);
			DB::rollback();
		}
	}

	/**
	 * Remove physical milestone attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $taskId   	Specific task id
	 * @return 
	 */
	public function deletePhysical(int $corporateId, int $projectId, int $milestoneId)
	{

		DB::beginTransaction();

		try{

			$this->physicalObj->find($milestoneId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove finance milestone attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $taskId   	Specific task id
	 * @return 
	 */
	public function deleteFinance(int $corporateId, int $projectId, int $milestoneId)
	{

		DB::beginTransaction();

		try{

			$this->financialObj->find($milestoneId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}
} // END class MilestoneRepository 