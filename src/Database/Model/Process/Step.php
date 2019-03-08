<?php

namespace Joesama\Project\Database\Model\Process;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function getPlainDescriptionAttribute($value)
    {
        return Str::limit(strip_tags($this->attributes['description']),100);
    }

}
