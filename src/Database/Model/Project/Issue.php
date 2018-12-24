<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class Issue extends Model
{
	protected $table = 'issue';

    /**
     * Get the task's project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the task's assignee.
     */
    public function assignee()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }

    /**
     * Get the task's progress.
     */
    public function progress()
    {
        return  $this->hasMany(MasterData::class,'progress_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['assignee','progress']);
    }
}
