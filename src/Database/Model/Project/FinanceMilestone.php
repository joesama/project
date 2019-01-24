<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceMilestone extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_milestone_finance';
    protected $guarded = ['id'];

    /**
     * Get the project info.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get all of the tags for the milstone.
     */
    public function tags()
    {
        return $this->morphToMany(TagMilestone::class, 'taggable');
    }

}
