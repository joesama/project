<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class Incident extends Model
{
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

    /**
     * Lost Time Injuries (LTI)
     */
    public function scopeLostTime($query)
    {
        return $query->where('id', 8);
    }

    /**
     * Unsafe Act / Unsafe Condition
     */
    public function scopeUnsafe($query)
    {
        return $query->where('id', 9);
    }

    /**
     * Stop Work Order
     */
    public function scopeStop($query)
    {
        return $query->where('id', 10);
    }

    /**
     * Summon By Authorities
     */
    public function scopeSummon($query)
    {
        return $query->where('id', 11);
    }

    /**
     * Complaint By Communities
     */
    public function scopeComplaint($query)
    {
        return $query->where('id', 12);
    }

}