<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Process\Step;

class ProjectApprovalWorkflow extends Model
{
    use SoftDeletes;
    
	protected $table = 'project_approval_workflow';
    protected $guarded = ['id'];

    /**
     * Get the workflow card.
     */
    public function approval()
    {
        return $this->belongsTo(ProjectApproval::class,'project_approval_id','id');
    }
    
    /**
     * Get the workflow profile.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }
    
    /**
     * Get the workflow profile.
     */
    public function step()
    {
        return $this->belongsTo(Step::class,'step_id','id');
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
                }])->with(['step' => function($query){
                    $query->component();
                }]);
    }
}
