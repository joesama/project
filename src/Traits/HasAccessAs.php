<?php
namespace Joesama\Project\Traits;

use Illuminate\Support\Facades\Cache;
use Joesama\Project\Database\Model\Organization\Profile;

trait HasAccessAs{
	

	/**
	 * Get Current User Profile
	 * @return Profile
	 */
	public function profile()
	{
		$profile = Cache::get('profile-'.auth()->id());

		if(is_null($profile)){
		$profile = Cache::remember(
				'profile-'.auth()->id(), 60, function () {
			    return Profile::where('user_id',auth()->id())->with('role')->first();
			});
		}

		view()->share('profile',$profile);

		return $profile;
	}

	/**
	 * Get Current User Profile Role In Project
	 * @return Profile
	 */
	public function roleInProject()
	{
		return data_get($this->profile(),'role')->where('pivot.project_id',request()->segment(5));
	}


	/**
	 * Was Project Manager
	 */
	public function wasProjectManager()
	{
		return (data_get($this->profile(),'role')->where('id',2)->count() > 0 ) ? TRUE : FALSE;
	}

	/**
	 * Is Current Project Manager
	 */
	public function isProjectManager()
	{	
		$pm  = 	data_get($this->profile(),'role')
					->where('id',2)
					->where('pivot.project_id',request()->segment(5))
					->count();

		view()->share('isProjectManager',($pm > 0 ) ? TRUE : FALSE);

		return ($pm > 0 ) ? TRUE : FALSE;
	}

}