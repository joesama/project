<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\ProgressNote;
use Joesama\Project\Database\Model\Project\TagMilestone;

class Plan extends Model
{
    use SoftDeletes;

	protected $table = 'plan';
    protected $guarded = ['id'];
    protected $appends = ['start_date','end_date'];

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
    public function taskstat()
    {
        return $this->belongsTo(MasterData::class,'status_id','id');
    }

    /**
     * Get all of the tags for the milstone.
     */
    public function tags()
    {
        return $this->morphToMany(TagMilestone::class, 'taggable');
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

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($this->attributes['end'])->format('d-m-Y');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($this->attributes['start'])->format('d-m-Y');
    }
    
    /**
     * Get the task's indicator.
     */
    public function indicator()
    {
        return  $this->belongsTo(MasterData::class,'indicator_id');
    }
}
