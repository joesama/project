<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Client;
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

	public function __construct(Project $project , Client $client)
	{
		$this->projectModel = $project;
		$this->clientModel = $client;
	}

	/**
	 * Create New Project
	 *
	 * @return Joesama\Project\Database\Model\Project\Project
	 **/
	public function initProject(\Illuminate\Support\Collection $projectData)
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

			$inputData->each(function($record,$field){
				if(in_array($field, ['start','end'])):
					$record = Carbon::parse($record)->toDateTimeString();
				endif;
				$this->projectModel->{$field} = $record;
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
	public function initClient(\Illuminate\Support\Collection $clientData)
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

			$inputData->each(function($record,$field){
				$this->clientModel->{$field} = $record;
			});

			$this->clientModel->save();

			DB::commit();

			return $this->clientModel;

		}catch( \Exception $e){

			DB::rollback();
		}
	}


} // END class MakeProjectRepository 