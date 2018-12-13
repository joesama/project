<?php

namespace Joesama\Project\Database\Model\Master;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
	protected $table = 'master_state';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    /**
     * Get the country state.
     */
    public function city()
    {
        return $this->hasMany(State::class,'state_id','id');
    }

}
