<?php

namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\ProjectInfoWorkflow;

class ProjectInfo extends Model
{
    use SoftDeletes;
    
	protected $table = 'project_info';

    protected $guarded = ['id'];

    protected $appends = ['generation_date','aging_action'];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }
    /**
     * Get the card workflow status.
     */
    public function workflow()
    {
        return $this->hasMany(ProjectInfoWorkflow::class,'project_info_id','id');
    }

    /**
     * Get the report status.
     */
    public function status()
    {
        return $this->belongsTo(MasterData::class,'workflow_id','id');
    }

    /**
     * Get the report status.
     */
    public function creator()
    {
        return $this->belongsTo(Profile::class,'creator_id','id');
    }

    /**
     * Get the report status.
     */
    public function nextby()
    {
        return $this->belongsTo(Profile::class,'need_action','id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['status'])
                    ->with(['workflow' => function($query){
                        $query->component();
                    }])
                    ->with(['project']);
    }

    public function getGenerationDateAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function getAgingActionAttribute($value)
    {
        $endDate = ($this->approve_date != null) ? Carbon::parse($this->approve_date) : Carbon::now(); 

        return Carbon::parse($this->updated_at)->diffInDays($endDate);
    }
}
