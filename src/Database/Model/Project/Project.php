<?php

namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\ProjectLad;
use Joesama\Project\Database\Model\Project\ProjectRetention;
use Joesama\Project\Database\Model\Project\ProjectVo;

class Project extends Model
{
    protected $table = 'project';
    protected $guarded = ['id'];
    protected $appends = ['start_date','end_date','in_charge'];

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
    public function manager()
    {
        return $this->belongsToMany(Profile::class,'project_role','project_id','profile_id')
        ->wherePivot('role_id',1);
    }

    /**
     * Get the  client partner for project.
     */
    public function profile()
    {
        return $this->belongsToMany(Profile::class,'project_role','project_id','profile_id');
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
     * Get the report progress.
     */
    public function task()
    {
        return $this->hasMany(Task::class,'project_id','id');
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

    public function scopeComponent($query)
    {
        return $query->with([
            'client','profile','task.progress',
            'corporate','partner','attributes',
            'hsecard','manager','incident','claim',
            'payment','retention','lad','vo'
        ]);
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getInChargeAttribute($value)
    {
        return $this->profile()->where('role_id',1)->first();
    }
}
