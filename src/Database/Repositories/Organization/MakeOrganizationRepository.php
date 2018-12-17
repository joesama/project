<?php
namespace Joesama\Project\Database\Repositories\Organization; 

use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Organization\ProfileRole;
use DB;

/**
 * Data Handling For Create Project Record
 *
 * @package default
 * @author 
 **/
class MakeOrganizationRepository 
{

	public function __construct(
		Corporate $model,
		Profile $profile,
		ProfileRole $role
	){
		$this->corporatetModel = $model;
		$this->profileModel = $profile;
		$this->roleModel = $role;
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

	/**
	 * Create New Profile
	 *
	 * @return Joesama\Project\Database\Model\Organization\Profile
	 **/
	public function initProfile($profileData)
	{
		$inputData = collect($profileData)->intersectByKeys([
		    'corporate_id' => null,
			'name' => null,
			'abbr'=> null,
			'email'=> null,
			'phone'=> null
		]);

		DB::beginTransaction();

		try{

			$inputData->each(function($record,$field){
				$this->profileModel->{$field} = $record;
			});

			$this->profileModel->save();

			DB::commit();

			return $this->profileModel;

		}catch( \Exception $e){

			DB::rollback();
		}
	}

	/**
	 * Create New Role
	 *
	 * @return Joesama\Project\Database\Model\Organization\ProfileRole
	 **/
	public function initRole($roleData)
	{
		$inputData = collect($roleData)->intersectByKeys([
		    'role' => null,
		]);

		DB::beginTransaction();

		try{

			$inputData->each(function($record,$field){
				$this->roleModel->{$field} = $record;
			});

			$this->roleModel->save();

			DB::commit();

			return $this->roleModel;

		}catch( \Exception $e){

			DB::rollback();
		}
	}


} // END class MakeProjectRepository 