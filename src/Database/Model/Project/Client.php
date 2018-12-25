<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;

class Client extends Model
{
	protected $table = 'client';

   /**
     * Get the  client partner for project.
     */
    public function corporate()
    {
        return $this->belongsToMany(Corporate::class,'corporate_client','corporate_id','client_id');
    }

    /**
     * Get the project list.
     */
    public function project()
    {
        return $this->hasMany(Project::class,'client_id','id');
    }

}
