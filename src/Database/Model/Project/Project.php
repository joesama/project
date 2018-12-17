<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

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
}
