<?php

namespace Joesama\Project\Database\Model\Process;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Flow extends Model
{
	protected $table = 'process_flow';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
	
    protected $appends = ['plain_description'];

    /**
     * Get the corporate for project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

    /**
     * All Steps In Flow
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps()
    {
        return $this->hasMany(Step::class,'process_flow_id','id');
    }

    /**
     * Check If In Same Corporation.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSameGroup($query,$corporateId)
    {
        return $query->where('corporate_id',$corporateId);
    }

    public function getPlainDescriptionAttribute($value)
    {
        return Str::limit(strip_tags($this->attributes['description']),100);
    }
}
