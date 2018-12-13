<?php

namespace Joesama\Project\Database\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'master_country';
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the country state.
     */
    public function state()
    {
        return $this->hasMany(City::class,'country_id','id');
    }

}
