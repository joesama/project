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
        return $this->belongsToMany(ClientPartner::class,'project_partner','project_id','partner_id');
    }

}
