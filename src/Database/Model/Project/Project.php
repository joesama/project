<?php

namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Organization\ProfileRole;
use Joesama\Project\Database\Model\Project\Issue;
use Joesama\Project\Database\Model\Project\ProjectLad;
use Joesama\Project\Database\Model\Project\ProjectRetention;
use Joesama\Project\Database\Model\Project\ProjectVo;

class Project extends Model
{
    protected $table = 'project';
    protected $guarded = ['id'];
    protected $appends = ['start_date','end_date','in_charge','duration_word'];

    /**
     * Get the corporate for project.
     */
    public function approval()
    {
        return $this->hasOne(ProjectApproval::class,'project_id','id');
    }

    /**
     * Get the corporate for project.
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

    /**
     * Get the client for project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }

    /**
     * Get the  client manager for project.
     */
    public function admin()
    {
        return $this->belongsToMany(Profile::class,'project_role','project_id','profile_id')
        ->wherePivot('role_id',1);
    }

    /**
     * Get the  client manager for project.
     */
    public function manager()
    {
        return $this->belongsToMany(Profile::class,'project_role','project_id','profile_id')
        ->wherePivot('role_id',2);
    }

    /**
     * Get the  client partner for project.
     */
    public function profile()
    {
        return $this->belongsToMany(Profile::class,'project_role','project_id','profile_id')->withPivot(['role_id','step_id']);
    }

    /**
     * Get the  client partner for project.
     */
    public function role()
    {
        return $this->belongsToMany(ProfileRole::class,'project_role','project_id','role_id')->withPivot('profile_id');
    }

    /**
     * Get the  client partner for project.
     */
    public function partner()
    {
        return $this->belongsToMany(Client::class,'project_partner','project_id','partner_id');
    }

    /**
     * Get the report card list.
     */
    public function card()
    {
        return $this->hasMany(Card::class,'project_id','id');
    }

    /**
     * Get the report list.
     */
    public function report()
    {
        return $this->hasMany(Report::class,'project_id','id');
    }

    /**
     * Get the task progress.
     */
    public function task()
    {
        return $this->hasMany(Task::class,'project_id','id');
    }
    
    /**
     * Get the plan progress.
     */
    public function plan()
    {
        return $this->hasMany(Plan::class,'project_id','id');
    }

    /**
     * Get the issue progress.
     */
    public function issue()
    {
        return $this->hasMany(Issue::class,'project_id','id');
    }

    /**
     * Get the report progress.
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class,'project_id','id');
    }

    /**
     * Get the incident reported.
     */
    public function incident()
    {
        return $this->hasMany(Incident::class,'project_id','id');
    }

    /**
     * Get the project claim
     */
    public function claim()
    {
        return $this->hasMany(ProjectPayment::class,'project_id','id')->whereNotNull('claim_amount');
    }

    /**
     * Get the project payment
     */
    public function payment()
    {
        return $this->hasMany(ProjectPayment::class,'project_id','id')->whereNotNull('paid_amount');
    }

    /**
     * Get the project vo
     */
    public function vo()
    {
        return $this->hasMany(ProjectVo::class,'project_id','id');
    }

    /**
     * Get the project retention
     */
    public function retention()
    {
        return $this->hasMany(ProjectRetention::class,'project_id','id');
    }

    /**
     * Get the project retention
     */
    public function lad()
    {
        return $this->hasMany(ProjectLad::class,'project_id','id');
    }

    /**
     * Get the hse scored card.
     */
    public function hsecard()
    {
        return  $this->hasOne(HseScore::class,'id','hse_id');
    }

    /**
     * Get the project progress milestone
     */
    public function physical()
    {
        return $this->hasMany(PhysicalMilestone::class,'project_id','id');
    }

    /**
     * Get the project payment milestone
     */
    public function finance()
    {
        return $this->hasMany(FinanceMilestone::class,'project_id','id');
    }

    /**
     * Get the report progress.
     */
    public function scopeOnTrack($query)
    {
        return $query->whereDate('end','>',Carbon::now())->whereColumn('planned_progress', '<=' , 'actual_progress');
    }
    /**
     * Get the report progress.
     */
    public function scopeDelayed($query)
    {
        return $query->whereColumn('planned_progress', '>' , 'actual_progress');
    }

    /**
     * Get the report progress.
     */
    public function scopeSameGroup($query,$corporateId)
    {
        return $query->where('corporate_id',$corporateId);
    }

    /**
     * Get the report progress.
     */
    public function scopeWasApproved($query)
    {
        return $query->whereHas('approval',function($query){
            $query->whereNotNull('approved_by');
        });
    }

    /**
     * Get the report progress.
     */
    public function scopeActive($query)
    {
        return $query->wasApproved()->where('active',1);
    }

    /**
     * Get the report progress.
     */
    public function scopeNotActive($query)
    {
        return $query->wasApproved()->where('active',0);
    }

    /**
     * Get the unassign project to profile.
     */
    public function scopeUnassigned($query,$profileId)
    {
        return $query->whereNotExists(function ($query) use($profileId){
                $query->select('id')
                      ->from('project_role')
                      ->where('profile_id',$profileId);
            });
    }

    public function scopeComponent($query, $reportId = null)
    {
        return $query->with([
            'client','profile.role',
            'corporate','partner','attributes',
            'hsecard','manager','incident','claim',
            'retention','lad','vo','issue','role',
            'physical','finance'
        ])->with(['payment' => function($query) use($reportId){
            $query->orderBy('claim_date');
            $query->component($reportId);
        }])->with(['task' => function($query) {
            $query->orderBy('end');
            $query->component();
        }])->with(['issue' => function($query){
            $query->component();
        }])->with(['approval' => function($query){
            $query->component();
        }])->with(['card' => function($query) {
            $query->component();
        }])->with(['report' => function($query) {
            $query->component();
        }]);
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($this->attributes['end'])->format('d-m-Y');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($this->attributes['start'])->format('d-m-Y');
    }

    public function getDurationWordAttribute($value)
    {
        $startDate = Carbon::parse($this->attributes['start']);
        $endDate = $this->attributes['end'];

        return ucwords($startDate->diffForHumans($endDate,true));
    }

    public function getInChargeAttribute($value)
    {
        return $this->profile()->where('role_id',1)->first();
    }
}
