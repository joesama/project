<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Profile;

class ProjectInfoWorkflow extends Model
{
    use SoftDeletes;
    
	protected $table = 'project_info_workflow';
    protected $guarded = ['id'];

    /**
     * Get the workflow card.
     */
    public function info()
    {
        return $this->belongsTo(ProjectInfo::class,'project_info_id','id');
    }
    
    /**
     * Get the workflow profile.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }
    
    /**
     * Get the workflow next action profile.
     */
    public function nextAction()
    {
        return $this->belongsTo(Profile::class,'need_action','id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['profile' => function($query){
                        $query->component();
                    }]);
    }
}
