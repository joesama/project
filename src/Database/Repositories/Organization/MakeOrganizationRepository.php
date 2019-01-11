<?php
namespace Joesama\Project\Database\Repositories\Organization; 

use DB;
use Illuminate\Support\Collection;
use Joesama\Entree\Database\Model\User;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Organization\ProfileRole;

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
	 * Manage Profile Information
	 * 
	 * @param  Collection $profileData Form Request
	 * @param  int     $profileID   Profile Id
	 * @return [type]               [description]
	 */
	public function initProfile(Collection $profileData, ?int $profileID)
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

			$password = str_random(12);

			if(!is_null($profileID)){
				$this->profileModel = $this->profileModel->find($profileID);
			}

			$inputData->each(function($record,$field){
				$this->profileModel->{$field} = $record;
			});

			if(is_null($profileID)){

                $user = User::firstOrNew(['email' => $this->profileModel->email]);

                $user->username = $this->profileModel->email;

                $user->password = $password;

                $user->status = 1;

                $user->fullname = ucwords($this->profileModel->name);

                $user->save();

                $user->roles()->sync(4);

		      	if (config('joesama/entree::entree.validation')):

		            event('joesama.email.user: new', [$user]); else:

		            $user->sendWelcomeNotification($password);

		        endif;

				$this->profileModel->user_id = $user->id;
			}

			$this->profileModel->save();

			DB::commit();

			return $this->profileModel;

		}catch( \Exception $e){
			dd($e->getMessage());
			DB::rollback();
		}
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function assignProfile(Collection $profileData, int $profileID)
	{

		DB::beginTransaction();

		try{

			$this->profileModel = $this->profileModel->find($profileID);

			$this->profileModel->project()->attach($profileData->get('project_id'),['role_id' => $profileData->get('project_id')]);
			
			DB::commit();

			return $this->profileModel;

		}catch( \Exception $e){
			dd($e->getMessage());
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