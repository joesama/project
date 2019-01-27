<?php
namespace Joesama\Project\Database\Repositories\Project; 

use App\Jobs\Joesama\Project\Jobs\MailForAction;
use Carbon\Carbon;
use DB;
use Joesama\Project\Database\Model\Organization\Profile;
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

		$initialFlow = collect(config('joesama/project::workflow.1'))->keys()->first();

		$profile = Profile::where('user_id',auth()->id())->first();

		try{

			$card = Card::firstOrNew([
				'month' => $request->get('cycle'),
			]);

			if ( $initialFlow == $request->get('state') ){

				$card->project_id = $project->id;
				$card->card_date = Carbon::parse($request->get('start'))->format('Y-m-d');
				$card->card_end = Carbon::parse($request->get('end'))->format('Y-m-d');
				$card->creator_id = $profile->id;
			}

			$card->workflow_id = $request->get('state');
			$card->need_action = $request->get('need_action');
			$card->need_step = $request->get('need_step');
			$card->save();

			DB::commit();

			$this->initMonthlyWorkflow($card,$profile->id,$request->input());
			$this->lockProjectData($project,$request->get('type'));

			return $card;

		}catch( \Exception $e){
			dd($e->getMessage());
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

		$profile = Profile::where('user_id',auth()->id())->first();

		try{

			$report = Report::firstOrNew([
				'week' => $request->get('cycle'),
			]);

			if ( $initialFlow == $request->get('state') ){

				$report->project_id = $project->id;
				$report->report_date = Carbon::parse($request->get('start'))->format('Y-m-d');
				$report->report_end = Carbon::parse($request->get('end'))->format('Y-m-d');
				$report->creator_id = $profile->id;
			}

			$report->workflow_id = $request->get('state');
			$report->need_action = $request->get('need_action');
			$report->need_step = $request->get('need_step');
			$report->save();

			if ( $initialFlow == $request->get('state') ){
				$this->lockProjectData($project,$report,$request->get('type'));
			}

			if(!is_null($report->nextby)){
				$report->nextby->sendActionNotification($project,$report,$request->get('type'));
			}else{
				$report->creator->sendAcceptedNotification($project,$report,$request->get('type'));
			}

			DB::commit();

			$this->initWeeklyWorkflow($report,$profile->id,$request->input());

			return $report;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create Monthly Card Workflow
	 * 
	 * @param  Report 	$report       Get Report Header
	 * @param  int 		$profile      Profile Id
	 * @param  array  	$workflowData Get Form Data
	 * @return JJoesama\Project\Database\Model\Project\Card
	 **/
	public function initMonthlyWorkflow(
		Card $card,
		int $profile,
		array $workflowData
	){

		DB::beginTransaction();

		try{

			$workflow = new CardWorkflow([
				'remark' => array_get($workflowData,'remark'),
				'state' => array_get($workflowData,'status'),
				'profile_id' => $profile,
			]);

			$card->workflow()->save($workflow);

			DB::commit();

			return $card;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create Weekly Workflow
	 * 
	 * @param  Report 	$report       Get Report Header
	 * @param  int 		$profile      Profile Id
	 * @param  array  	$workflowData Get Form Data
	 * @return Joesama\Project\Database\Model\Project\Report
	 */
	public function initWeeklyWorkflow(
		Report $report,
		int $profile,
		array $workflowData
	){

		DB::beginTransaction();

		try{

			$reportWork = new ReportWorkflow([
				'remark' => array_get($workflowData,'remark'),
				'state' => array_get($workflowData,'status'),
				'profile_id' => $profile,
			]);

			$report->workflow()->save($reportWork);
			
			DB::commit();

			return $report;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Lock Project Data
	 *
	 * @param string $type 		Report Type	
	 * @param Report $project 	Project Data
	 **/
	public function lockProjectData(Project $project, $report, string $type)
	{

		$tasks = $project->task->where('end','<=',$report->report_end);

		$tasks->each(function($task) use($type,$report){

			$progress = $task->allProgress;
			$progress = ($type == 'weekly') ? $progress->where('report_id',null) :  $progress->where('card_id',null);

			$progress->each(function($prog) use($type,$report){
				
				if ($type == 'weekly') {
					$prog->report_id = $report->id;
				}

				if ($type == 'monthly') {
					$prog->card_id = $report->id;
				}

				$prog->save();
			});

			if($progress->isNotEmpty()){
				$task->actual_progress = $progress->last()->progress/100*$task->planned_progress;
				$task->save();
			}
			

		});
	}
} // END class MakeReportCardRepository 