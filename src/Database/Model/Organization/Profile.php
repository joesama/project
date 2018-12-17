<?php
namespace Joesama\Project\Database\Model\Organization;

use Joesama\Project\Database\Model\Project\Project;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table = 'profile';

    /**
     * Get the corporate.
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

    /**
     * Get the project profile.
     */
    public function project()
    {
        return $this->belongsToMany(Project::class,'project_role','project_id','profile_id');
    }

}
