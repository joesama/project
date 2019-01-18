<?php
namespace Joesama\Project\Traits;

use Illuminate\Support\Facades\Cache;

trait HasAccessAs{
	

	/**
	 * Get Current User Profile
	 * @return Profile
	 */
	public function profile()
	{
		return Cache::get('profile-'.auth()->id());
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

		return ($pm > 0 ) ? TRUE : FALSE;
	}

}