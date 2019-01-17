<?php
namespace Joesama\Project\Traits;

use Illuminate\Support\Facades\Cache;

trait HasAccessAs{
	
	/**
	 * Was Project Manager
	 */
	public function wasProjectManager()
	{
		return (data_get(Cache::get('profile-'.auth()->id()),'role')->where('id',2)->count() > 0 ) ? TRUE : FALSE;
	}

	/**
	 * Is Current Project Manager
	 */
	public function isProjectManager()
	{	
		$pm  = 	data_get(Cache::get('profile-'.auth()->id()),'role')
					->where('id',2)
					->where('pivot.project_id',request()->segment(5))
					->count();

		return ($pm > 0 ) ? TRUE : FALSE;
	}

}