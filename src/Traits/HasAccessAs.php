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
		if( !session()->has('profile-'.auth()->id()) ){
			session()->put(
	            'profile-'.auth()->id() , Profile::where('user_id',auth()->id())
	                                        ->with(['mails','role'])->first()
	        );
		}

		$profile = session('profile-'.auth()->id());

		view()->share('profile',$profile);

		return $profile;
	}

	/**
	 * Get Current User Profile
	 * @return Profile
	 */
	public function profileRefresh()
	{
		if( session()->has('profile-'.auth()->id()) ){
			session()->put(
	            'profile-'.auth()->id() , Profile::where('user_id',auth()->id())
	                                        ->with(['mails','role'])->first()
	        );
		}

		$profile = session('profile-'.auth()->id());

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
		return (data_get($this->profile(),'role')->where('id',2)->count() > 0 || $this->profile()->is_pm ) ? TRUE : FALSE;
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

		view()->share('isProjectManager',($pm > 0 || $this->profile()->is_pm ) ? TRUE : FALSE);

		return ($pm > 0 || $this->profile()->is_pm ) ? TRUE : FALSE;
	}

}