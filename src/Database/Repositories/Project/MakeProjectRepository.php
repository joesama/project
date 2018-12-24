<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\Task;
use Joesama\Project\Database\Model\Project\TaskProgress;
use DB;
use Carbon\Carbon;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class MakeProjectRepository 
{

	public function __construct(
		Project $project , 
		Client $client,
		Task $task
	){
		$this->projectModel = $project;
		$this->clientModel = $client;
		$this->taskModel = $task;
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
		    'contract' => null,
		    'bond' => null,
		    'start' => null,
		    'end' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->projectModel->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					if(in_array($field, ['start','end'])):
						$record = Carbon::parse($record)->toDateTimeString();
					endif;
					
					$this->projectModel->{$field} = $record;
				}
			});

			$this->projectModel->save();

			DB::commit();

			return $this->projectModel;

		}catch( \Exception $e){

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
				$this->clientModel->find($id);
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

			$this->taskModel->save();

			if($inputData->get('progress') == null){
				$this->taskModel->progress()->save(new TaskProgress([
					'progress' => 0
				]));
			}

			DB::commit();

			return $this->taskModel;

		}catch( \Exception $e){

			dd($e->getMessage());
			DB::rollback();
		}
	}


} // END class MakeProjectRepository 