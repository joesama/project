<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Model\Project\Report;
use DB;
use Carbon\Carbon;

/**
 * Data Handling For Create Project Card & Report Record
 *
 * @package default
 * @author 
 **/
class MakeReportCardRepository 
{

	/**
	 * Create New Project
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initProjectCard(\Joesama\Project\Database\Model\Project\Project $project)
	{

		DB::beginTransaction();

		try{

			$card = new Card([
				'project_id' => $project->id,
				'creator_id' => \Auth::user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

			$project->card()->save($card);

			DB::commit();

			return $project->with(['card' => function($query) use($card){
				$query->latest();
			}]);

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create New Project Report
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initProjectReport(\Joesama\Project\Database\Model\Project\Project $project)
	{

		DB::beginTransaction();

		try{

			$report = new Report([
				'project_id' => $project->id,
				'creator_id' => \Auth::user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

			$project->report()->save($report);

			DB::commit();

			return $project->with(['report' => function($query) use(report){
				$query->latest();
			}]);

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create Project Card Workflow
	 *
	 * @return oesama\Project\Database\Model\Project\Card
	 **/
	public function initProjectWorkflow(
		\Joesama\Project\Database\Model\Project\Card $card,
		array $workflowData
	){

		DB::beginTransaction();

		try{

			$workflow = new CardWorkflow([
				'remark' => data_get($workflowData,'remark'),
				'profile_id' => \Auth::user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

			$card->workflow()->save($workflow);

			DB::commit();

			return $card;

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create Project Report Workflow
	 *
	 * @return Joesama\Project\Database\Model\Project\Report
	 **/
	public function initCardWorkflow(
		\Joesama\Project\Database\Model\Project\Report $report,
		array $workflowData
	){

		DB::beginTransaction();

		try{

			$workflow = new CardWorkflow([
				'remark' => data_get($workflowData,'remark'),
				'profile_id' => \Auth::user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

			$report->workflow()->save($workflow);

			DB::commit();

			return $report;

		}catch( \Exception $e){

			DB::rollback();
		}
	}
} // END class MakeReportCardRepository 