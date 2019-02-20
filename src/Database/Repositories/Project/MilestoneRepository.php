<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Project\FinanceMilestone;
use Joesama\Project\Database\Model\Project\PhysicalMilestone;
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

			$this->physicalObj->save();

			$financial = $this->financialObj->where('progress_date',$this->physicalObj->progress_date)->first();

			$financial->planned = ($this->physicalObj->planned/100)*$this->physicalObj->project->value;

			$financial->save();
			
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

		$project = Project::with('finance')->find($projectId);
		$sumWeightage = $project->finance->sum('weightage');

		DB::beginTransaction();

		try{
			if(!is_null($milestoneId)){
				$this->financialObj = $this->financialObj->find($milestoneId);
				$sumWeightage = $sumWeightage - $this->financialObj->weightage;
			}

			$available = $project->value - $sumWeightage;

			$inputData->each(function($record,$field) use($available){
				if(!is_null($record)){
					$record = ($field == 'weightage') ? ( ($record > $available ) ? $available : $record ) : $record;
					$this->financialObj->{$field} = $record;
				}
			});

			$this->financialObj->save();

			$tag = TagMilestone::firstOrNew(['label' => strtoupper($request->get('group'))]);

			$this->financialObj->tags()->detach();

			$this->financialObj->tags()->save($tag);

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

			$this->physicalObj->find($milestoneId)->tags()->detach();
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

			$this->financialObj->find($milestoneId)->tags()->detach();
			$this->financialObj->find($milestoneId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}
} // END class MilestoneRepository 