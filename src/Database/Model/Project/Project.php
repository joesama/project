<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Carbon\Carbon;

class Project extends Model
{
    protected $table = 'project';
    protected $appends = ['start_date','end_date','in_charge'];

    /**
     * Get the client for project.
     */
    public function client()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
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
        return $this->hasMany(Report::class,'project_id','id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['client','profile','task']);
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
