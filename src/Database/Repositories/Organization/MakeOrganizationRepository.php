<?php
namespace Joesama\Project\Database\Repositories\Organization; 

use Joesama\Project\Database\Model\Organization\Corporate;
use DB;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class MakeOrganizationRepository 
{

	public function __construct(Corporate $model)
	{
		$this->corporatetModel = $model;
	}

	/**
	 * Create New Corporate
	 *
	 * @return Joesama\Project\Database\Model\Organization\Corporate
	 **/
	public function initCorporate($corporateData)
	{
		$inputData = collect($corporateData)->intersectByKeys([
		    'name' => 0
		]);

		DB::beginTransaction();

		try{

			$inputData->each(function($record,$field){
				$this->corporatetModel->{$field} = $record;
			});

			$this->corporatetModel->save();

			DB::commit();

			return $this->corporatetModel;

		}catch( \Exception $e){

			DB::rollback();
		}
	}


} // END class MakeProjectRepository 