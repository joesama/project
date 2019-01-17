<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class ProjectApprovalWorkflow extends Model
{
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
     * Get the workflow next action profile.
     */
    public function nextAction()
    {
        return $this->belongsTo(Profile::class,'need_action','id');
    }

}
