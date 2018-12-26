<?php

namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Task;

class Project extends Model
{
    protected $table = 'project';
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
     * Get the  client partner for project.
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
     * Get the report progress.
     */
    public function scopeSameGroup($query)
    {
        return $this->where('corporate_id',request()->segment(4));
    }

    public function scopeComponent($query)
    {
        return $query->with(['client','profile','task.progress','corporate','partner','attributes']);
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