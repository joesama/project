<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class ProjectApproval extends Model
{
	protected $table = 'project_approval';
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
        return $this->hasMany(ProjectApprovalWorkflow::class,'project_approval_id','id');
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
        return $query->with(['status','project'])
                    ->with(['workflow' => function($query){
                        $query->component();
                    }]);
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
