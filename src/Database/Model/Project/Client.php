<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Corporate;

class Client extends Model
{
    use SoftDeletes;
    
	protected $table = 'client';
    protected $guarded = ['id'];

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
