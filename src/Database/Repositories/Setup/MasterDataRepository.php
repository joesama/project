<?php
namespace Joesama\Project\Database\Repositories\Setup; 

use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Master\Master;
use Joesama\Project\Database\Model\Master\MasterData;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class MasterDataRepository 
{

	public function __construct(
		Master $master,
		MasterData $masterData
	){
		$this->masterObj = $master;
		$this->dataObj = $masterData;
	}

	/**
	 * Retrieve Master Record
	 *
	 * @return Joesama\Project\Database\Model\Master\Master
	 **/
	public function listMaster($corporateId)
	{
		return $this->masterObj->paginate();
	}

	/**
	 * Retrieve Master Data Record
	 *
	 * @param int $corporateId - icurrent corporate id
	 * @param int $masterId - current master id
	 * @return Joesama\Project\Database\Model\Master\MasterData
	 **/
	public function listData(int $corporateId, int $masterId)
	{
		return $this->dataObj->where('master_id',$masterId)->paginate();
	}

	/**
	 * Create Master Category
	 *
	 * @return Joesama\Project\Database\Model\Master\Master
	 **/
	public function initMaster(\Illuminate\Support\Collection $masterData, $id = null)
	{
		$inputData = collect($masterData)->intersectByKeys([
		    'description' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->masterObj = $this->masterObj->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					$this->masterObj->{$field} = $record;
				}
			});

			$this->masterObj->save();

			DB::commit();

			return $this->masterObj;

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create Master Category
	 *
	 * @return Joesama\Project\Database\Model\Master\MasterData
	 **/
	public function initData(\Illuminate\Support\Collection $masterData, $id = null)
	{
		$inputData = collect($masterData)->intersectByKeys([
		    'master_id' => null,
		    'description' => null
		]);

		DB::beginTransaction();

		try{
			if(!is_null($id)){
				$this->dataObj = $this->dataObj->find($id);
			}

			$inputData->each(function($record,$field){
				if(!is_null($record)){
					$this->dataObj->{$field} = $record;
				}
			});

			$this->dataObj->save();

			DB::commit();

			return $this->dataObj;

		}catch( \Exception $e){

			DB::rollback();
		}
	}


} // END class MasterDataRepository 