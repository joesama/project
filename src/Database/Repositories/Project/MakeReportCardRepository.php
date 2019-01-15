<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use DB;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Report;
use Joesama\Project\Database\Model\Project\ReportWorkflow;

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
	 * @param 	Project $project Project Related
	 * @param 	Request $request Report Data
	 * @return  Project
	 **/
	public function initMonthly(Project $project, $request)
	{

		DB::beginTransaction();

		try{
dd($request->all());
			$card = new Card([
				'project_id' => $project->id,
				'creator_id' => \Auth::user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
dd($card);
			// $project->card()->save($card);

			DB::commit();

			return $project;

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create New Project Report
	 *
	 * @param 	Project $project Project Related
	 * @param 	Request $request Report Data
	 * @return  Project
	 **/
	public function initWeekly(Project $project, $request)
	{

		DB::beginTransaction();

		$initialFlow = collect(config('joesama/project::workflow.1'))->keys()->first();

		try{

			$report = Report::firstOrNew([
				'week' => $request->get('cycle'),
			]);

			if ( $initialFlow == $request->get('state') ){

				$report->project_id = $project->id;
				$report->report_date = Carbon::parse($request->get('start'))->format('Y-m-d');
				$report->report_end = Carbon::parse($request->get('end'))->format('Y-m-d');
				$report->report_date = Carbon::now()->format('Y-m-d H:i:s');
				$report->creator_id = \Auth::user()->id;
				$report->save();

				DB::commit();

			}

			return $report;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create Project Card Workflow
	 *
	 * @return oesama\Project\Database\Model\Project\Card
	 **/
	public function initProjectWorkflow(
		Card $card,
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
	 * Create Weekly Workflow
	 * @param  Report $report       Get Report Header
	 * @param  array  $workflowData Get Form Data
	 * @return Joesama\Project\Database\Model\Project\Report
	 */
	public function initWeeklyWorkflow(
		Report $report,
		array $workflowData
	){

		DB::beginTransaction();

		try{

			$workflow = new ReportWorkflow([
				'remark' => data_get($workflowData,'remark'),
				'state' => data_get($workflowData,'state'),
				'profile_id' => \Auth::user()->id,
			]);

			$report->workflow()->save($workflow);

			DB::commit();

			return $report;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}
} // END class MakeReportCardRepository 