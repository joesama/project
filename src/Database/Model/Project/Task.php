<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class Task extends Model
{
	protected $table = 'task';

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
        return  $this->hasMany(TaskProgress::class,'task_id');
    }

}
