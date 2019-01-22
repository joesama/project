<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

	protected $table = 'task';
    protected $guarded = ['id'];
    protected $appends = [];

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
        return  $this->hasOne(TaskProgress::class,'task_id')->latest();
    }

    /**
     * Get the task's progress.
     */
    public function allProgress()
    {
        return  $this->hasMany(TaskProgress::class,'task_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['assignee','progress','project']);
    }

    /**
     * Get the report progress.
     * @TODO should get the latest progress
     */
    public function scopeOverdue($query)
    {
        return $query->whereDate('end','<',Carbon::now())->whereColumn('planned_progress', '>' , 'actual_progress');
    }

    /**
     * Get the report progress.
     * @TODO should get the latest progress
     */
    public function scopeComplete($query)
    {
        return $query->whereDate('end','<',Carbon::now())->whereColumn('planned_progress', 'actual_progress');
    }

}
