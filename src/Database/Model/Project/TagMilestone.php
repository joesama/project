<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagMilestone extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_milestone_tag';
    protected $guarded = ['id'];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function physical()
    {
        return $this->morphedByMany(PhysicalMilestone::class, 'taggable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function finance()
    {
        return $this->morphedByMany(FinanceMilestone::class, 'taggable');
    }

}
