<?php
namespace Joesama\Project\Database\Model\Organization;

use Joesama\Project\Database\Model\Project\Project;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table = 'profile';
    protected $guarded = ['id'];

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

    /**
     * Get the report progress.
     */
    public function scopeSameGroup($query)
    {
        return $this->where('corporate_id',request()->segment(4));
    }

}
