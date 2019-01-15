<?php
namespace Joesama\Project\Database\Model\Organization;

use Illuminate\Database\Eloquent\Model;
use Joesama\Entree\Database\Model\User;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\Project;

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
     * Get the position.
     */
    public function position()
    {
        return $this->belongsTo(MasterData::class,'position_id','id');
    }

    /**
     * Get the project profile.
     */
    public function project()
    {
        return $this->belongsToMany(Project::class,'project_role','profile_id','project_id');
    }

    /**
     * Get the project profile.
     */
    public function role()
    {
        return $this->belongsToMany(ProfileRole::class,'project_role','profile_id','role_id')->withPivot('project_id');
    }

    /**
     * Get the profile user.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the report progress.
     */
    public function scopeSameGroup($query,$corporateId)
    {
        return $this->where('corporate_id',$corporateId);
    }

    public function scopeComponent($query)
    {
        return $query->with([
            'project.role','corporate','user','position'
        ]);
    }

    public function scopeIsProjectManager($query,$projectId)
    {
        return $query->role()->where('project_id',$projectId)->where('role_id',2);
    }

}
