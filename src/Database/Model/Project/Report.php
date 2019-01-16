<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class Report extends Model
{
	protected $table = 'project_report';
    protected $guarded = ['id'];

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
        return $this->hasMany(ReportWorkflow::class,'report_id','id');
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


    public function scopeComponent($query)
    {
        return $query->with(['status','project','workflow']);
    }

}
