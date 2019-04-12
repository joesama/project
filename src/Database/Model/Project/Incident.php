<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use SoftDeletes;
    
	protected $table = 'project_incident';
    protected $guarded = ['id'];
    protected $appends = ['report_date'];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the masterdata.
     */
    public function type()
    {
        return $this->belongsTo(MasterData::class,'incident_id','id');
    }

    /**
     * Get the masterdata.
     */
    public function reporter()
    {
        return $this->belongsTo(Profile::class,'report_by','user_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['type','reporter','project']);
    }

    public function getReportDateAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d-m-Y H:i:s');
    }

}
