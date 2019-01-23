<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Attribute;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\HseScore;
use Joesama\Project\Database\Model\Project\Incident;
use Joesama\Project\Database\Model\Project\Issue;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\ProjectLad;
use Joesama\Project\Database\Model\Project\ProjectPayment;
use Joesama\Project\Database\Model\Project\ProjectRetention;
use Joesama\Project\Database\Model\Project\ProjectVo;
use Joesama\Project\Database\Model\Project\Risk;
use Joesama\Project\Database\Model\Project\Task;
use Joesama\Project\Database\Model\Project\TaskProgress;
use Joesama\Project\Traits\ProjectCalculator;
use Exception;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class MakeProjectRepository 
{
	use ProjectCalculator;

	public function __construct(
		Project $project , 
		Client $client,
		Task $task,
		Issue $issue,
		Risk $risk
	){
		$this->projectModel = $project;
		$this->clientModel = $client;
		$this->taskModel = $task;
		$this->issueModel = $issue;
		$this->riskModel = $risk;
	}

	/**
	 * Create New Project
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initProject(\Illuminate\Support\Collection $projectData, $id = null)
	{
		$inputData = collect($projectData)->intersectByKeys([
		    'client_id' => 0,
		    'corporate_id' => 0,
		    'name' => null, 
		    'value' => null,
		    'contract' => null,
		    'gp_propose' => null,
		    'gp_latest' => null,
		    'bond' => null,
		    'scope' => null,
		    'start' => null,
		    'end' => null,
		    'active' => 0
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->projectModel = $this->projectModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					if(in_array($field, ['start','end'])):
						$record = Carbon::createFromFormat('d/m/Y',$record)->toDateTimeString();
					endif;
					
					$this->projectModel->{$field} = $record;
				}
			});

			if(is_null($id)){

				$startDate = Carbon::parse($this->projectModel->start);

				$endDate = Carbon::parse($this->projectModel->end);

				$hse = new HseScore();

				$hse->project_hour = $startDate->diffInHours($endDate);

				$hse->save();

				$this->projectModel->active = 0;
				$this->projectModel->hse_id = $hse->id;
				$this->projectModel->effective_days = $this->effectiveDays($this->projectModel->start,$this->projectModel->end);

				$projectAdmin = Profile::where('user_id',auth()->id())->with('role')->first();

				$this->projectModel->profile()->attach($projectAdmin->id,['role_id' => 1]);
			}

			$this->projectModel->save();


			$this->projectModel->profile()->sync([
				$projectData->get('manager_id') => ['role_id' => 2],
				$projectData->get('approver_id') => ['role_id' => 4],
				$projectData->get('validator_id') => ['role_id' => 5],
				$projectData->get('reviewer_id') => ['role_id' => 3],
				$projectData->get('acceptance_id') => ['role_id' => 4]
			]);

			if(is_null($id)){
				$approval = new ProjectWorkflowRepository();
				$approval->registerProject($this->projectModel);
			}

			DB::commit();

			return $this->projectModel;

		}catch( Exception $e){
			throw new Exception($e->getMessage(), 1);

			DB::rollback();
		}
	}

	/**
	 * Create New Client
	 *
	 * @return Joesama\Project\Database\Model\Project\Client
	 **/
	public function initClient(\Illuminate\Support\Collection $clientData, $id = null)
	{
		$inputData = collect($clientData)->intersectByKeys([
		    'name' => null,
		    'corporate_id' => null,
		    'phone' => null,
		    'contact'=> null,
		    'manager' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->clientModel = $this->clientModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					$this->clientModel->{$field} = $record;
				}
			});

			$this->clientModel->save();

			DB::commit();

			return $this->clientModel;

		}catch( \Exception $e){
			throw new Exception($e->getMessage(), 1);
			
			DB::rollback();
		}
	}

	/**
	 * Create New Task
	 *
	 * @return Joesama\Project\Database\Model\Project\Task
	 **/
	public function initTask(\Illuminate\Support\Collection $taskData, $id = null)
	{
		$inputData = collect($taskData)->intersectByKeys([
		    'name' => null,
		    'project_id' => null,
		    'profile_id' => null,
		    'start'=> null,
		    'end' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->taskModel = $this->taskModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					if(in_array($field, ['start','end'])):
						$record = Carbon::createFromFormat('d/m/Y',$record)->toDateTimeString();
					endif;

					$this->taskModel->{$field} = $record;
				}
			});
			$this->taskModel->effective_days = $this->effectiveDays($this->taskModel->start,$this->taskModel->end);
			$this->taskModel->save();

			$this->taskModel->progress()->save(new TaskProgress([
				'progress' => ($taskData->get('task_progress') > 100) ? 100 : $taskData->get('task_progress',0)
			]));


			DB::commit();

			return $this->taskModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove task attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $taskId   	Specific task id
	 * @return 
	 */
	public function deleteTask(int $corporateId, int $projectId, int $taskId)
	{

		DB::beginTransaction();

		try{

			$this->taskModel->find($taskId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Issue
	 *
	 * @return Joesama\Project\Database\Model\Project\Issue
	 **/
	public function initIssue(Collection $issueData, $id = null)
	{
		$inputData = collect($issueData)->intersectByKeys([
		    'name' => null,
		    'project_id' => null,
		    'profile_id' => null,
		    'progress_id'=> null,
		    'description' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->issueModel = $this->issueModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					if(in_array($field, ['start','end'])):
						$record = Carbon::createFromFormat('d/m/Y',$record)->toDateTimeString();
					endif;

					$this->issueModel->{$field} = $record;
				}
			});

			$this->issueModel->save();

			DB::commit();

			return $this->issueModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove issue attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $taskId   	Specific task id
	 * @return 
	 */
	public function deleteIssue(int $corporateId, int $projectId, int $taskId)
	{

		DB::beginTransaction();

		try{

			$this->issueModel->find($taskId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Risk
	 *
	 * @return Joesama\Project\Database\Model\Project\Risk
	 **/
	public function initRisk(Collection $riskData, $id = null)
	{
		$inputData = collect($riskData)->intersectByKeys([
		    'name' => null,
		    'project_id' => null,
		    'severity_id'=> null,
		    'description' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->riskModel = $this->riskModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					if(in_array($field, ['start','end'])):
						$record = Carbon::createFromFormat('d/m/Y',$record)->toDateTimeString();
					endif;

					$this->riskModel->{$field} = $record;
				}
			});

			$this->riskModel->save();

			DB::commit();

			return $this->riskModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove risk attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $taskId   	Specific task id
	 * @return 
	 */
	public function deleteRisk(int $corporateId, int $projectId, int $riskId)
	{

		DB::beginTransaction();

		try{

			$this->riskModel->find($riskId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Partner
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initPartner(Collection $partnerData, $id = null)
	{
		$inputData = collect($partnerData)->intersectByKeys([
		    'partner_id'=> null
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find($id);
			$this->projectModel->partner()->detach(data_get($inputData,'partner_id'));
			$this->projectModel->partner()->attach(data_get($inputData,'partner_id'));

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove partner attached to project
	 * 
	 * @param  int    $corporateId Corporate Id
	 * @param  int    $projectId   Project Id
	 * @param  int    $partnerId   Specific partner id
	 * @return 
	 */
	public function deletePartner(int $corporateId, int $projectId, int $partnerId)
	{

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find($projectId);
			$this->projectModel->partner()->detach($partnerId);

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Attribute
	 *
	 * @return Joesama\Project\Database\Model\Project\Attribute
	 **/
	public function initAttribute(Collection $partnerData, $id = null)
	{
		$inputData = collect($partnerData)->intersectByKeys([
		    'project_id'=> null,
		    'variable'=> null,
		    'data'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));

			$attr = new Attribute([
			    'variable'=> data_get($inputData,'variable'),
			    'data'=> data_get($inputData,'data')
			]);

			$this->projectModel->attributes()->save($attr);

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Remove attributes attached to project
	 * 
	 * @param  int    $corporateId Corporate Id
	 * @param  int    $projectId   Project Id
	 * @param  int    $attributeId   Specific attribute id
	 * @return 
	 */
	public function deleteAttribute(int $corporateId, int $projectId, int $attributeId)
	{

		DB::beginTransaction();

		try{

			Attribute::where('project_id',$projectId)->where('id',$attributeId)->delete();

			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Incident Report
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initIncident(Collection $partnerData, $id = null)
	{
		$inputData = collect($partnerData)->intersectByKeys([
		    'project_id'=> null,
		    'incident_id'=> null,
		    'report_by'=> null,
		    'incident'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));

			$incident = new Incident([
			    'incident_id'=> data_get($inputData,'incident_id'),
			    'incident'=> data_get($inputData,'incident'),
			    'report_by'=> data_get($inputData,'report_by')
			]);

			$this->projectModel->incident()->save($incident);

			$currentIncident = data_get($inputData,'incident_id');

			$scoreCard = $this->projectModel->hsecard;
			$incidentRecord = $this->projectModel->incident;
			$incidentGroup = $incidentRecord->groupBy('incident_id');

			$scoreCard->update([
				'acc_lti' => collect($incidentGroup->get(15))->sum('incident'), //8
				'zero_lti' => 0, //9
				'unsafe' => collect($incidentGroup->get(16))->sum('incident'),//9
				'stop' => collect($incidentGroup->get(17))->sum('incident'),//10
				'summon' => collect($incidentGroup->get(18))->sum('incident'),//11
				'complaint' => collect($incidentGroup->get(19))->sum('incident') //12
			]);

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}


	/**
	 * Remove incident attached to project
	 * 
	 * @param  int    $corporateId 	Corporate Id
	 * @param  int    $projectId   	Project Id
	 * @param  int    $incidentId   	Specific task id
	 * @return 
	 */
	public function deleteIncident(int $corporateId, int $projectId, int $incidentId)
	{

		DB::beginTransaction();

		try{

			Incident::find($incidentId)->delete();

			$this->projectModel = $this->projectModel->find($projectId);

			$scoreCard = $this->projectModel->hsecard;
			$incidentRecord = $this->projectModel->incident;
			$incidentGroup = $incidentRecord->groupBy('incident_id');

			$scoreCard->update([
				'acc_lti' => collect($incidentGroup->get(15))->sum('incident'), //8
				'zero_lti' => 0, //9
				'unsafe' => collect($incidentGroup->get(16))->sum('incident'),//9
				'stop' => collect($incidentGroup->get(17))->sum('incident'),//10
				'summon' => collect($incidentGroup->get(18))->sum('incident'),//11
				'complaint' => collect($incidentGroup->get(19))->sum('incident') //12
			]);
			
			DB::commit();

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Claim Report
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initClaim(Collection $claimData, $id = null)
	{
		$inputData = collect($claimData)->intersectByKeys([
		    'project_id'=> null,
		    'claim_date'=> null,
		    'claim_report_by'=> null,
		    'claim_amount'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));

			$claim = new ProjectPayment([
			    'claim_date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'claim_date'))->toDateTimeString(),
			    'claim_amount'=> data_get($inputData,'claim_amount'),
			    'claim_report_by'=> data_get($inputData,'claim_report_by')
			]);

			$this->projectModel->payment()->save($claim);

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New Incident Report
	 *
	 * @return Joesama\Project\Database\Model\Project\ProjectPayment
	 **/
	public function updateClaim(Collection $claimData, $id)
	{
		$inputData = collect($claimData)->intersectByKeys([
		    'paid_date'=> null,
		    'paid_amount'=> null,
		]);

		DB::beginTransaction();

		try{

			$payment = ProjectPayment::find($id);
			$payment->paid_date = Carbon::createFromFormat('d/m/Y',data_get($inputData,'paid_date'))->toDateTimeString();
			$payment->paid_amount = data_get($inputData,'paid_amount');
			$payment->save();

			DB::commit();

			return $payment;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New VO 
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initVo(Collection $voData, $id = null)
	{

		$inputData = collect($voData)->intersectByKeys([
		    'project_id'=> null,
		    'date'=> null,
		    'report_by'=> null,
		    'amount'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));
			
			if(is_null($id)){

			$vo = new ProjectVo([
			    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
			    'amount'=> data_get($inputData,'amount'),
			    'report_by'=> data_get($inputData,'report_by')
			]);

			$this->projectModel->vo()->save($vo);

			}else{

				ProjectVo::find($id)->update([
				    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
				    'amount'=> data_get($inputData,'amount'),
				    'report_by'=> data_get($inputData,'report_by')
				]);

			}

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New VO 
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initRetention(Collection $retentionData, $id = null)
	{

		$inputData = collect($retentionData)->intersectByKeys([
		    'project_id'=> null,
		    'date'=> null,
		    'report_by'=> null,
		    'amount'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));

			if(is_null($id)){

			$vo = new ProjectRetention([
			    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
			    'amount'=> data_get($inputData,'amount'),
			    'report_by'=> data_get($inputData,'report_by')
			]);

			$this->projectModel->retention()->save($vo);

			}else{

				ProjectRetention::find($id)->update([
				    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
				    'amount'=> data_get($inputData,'amount'),
				    'report_by'=> data_get($inputData,'report_by')
				]);

			}

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

	/**
	 * Create New LAD 
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initLad(Collection $ladData, $id = null)
	{

		$inputData = collect($ladData)->intersectByKeys([
		    'project_id'=> null,
		    'date'=> null,
		    'report_by'=> null,
		    'amount'=> null,
		]);

		DB::beginTransaction();

		try{

			$this->projectModel = $this->projectModel->find(data_get($inputData,'project_id'));

			if(is_null($id)){

			$vo = new ProjectLad([
			    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
			    'amount'=> data_get($inputData,'amount'),
			    'report_by'=> data_get($inputData,'report_by')
			]);

			$this->projectModel->retention()->save($vo);

			}else{

				ProjectLad::find($id)->update([
				    'date'=> Carbon::createFromFormat('d/m/Y',data_get($inputData,'date'))->toDateTimeString(),
				    'amount'=> data_get($inputData,'amount'),
				    'report_by'=> data_get($inputData,'report_by')
				]);

			}

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}

} // END class MakeProjectRepository 