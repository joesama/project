<?php

namespace Joesama\Project\Database\Model\Process;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\ProfileRole;

class Step extends Model
{
	protected $table = 'process_step';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    protected $appends = ['plain_description'];

    /**
     * Parent Flow
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flow()
    {
        return $this->belongsTo(Steps::class,'process_flow_id','id');
    }

    /**
     * Parent Flow
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(ProfileRole::class,'role_id','id');
    }

    /**
     * Parent Flow
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(MasterData::class,'status_id','id');
    }

    public function getPlainDescriptionAttribute($value)
    {
        return Str::limit(strip_tags($this->attributes['description']),100);
    }

}
