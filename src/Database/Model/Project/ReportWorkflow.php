<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class ReportWorkflow extends Model
{
	protected $table = 'project_report_workflow';

    /**
     * Get the workflow report.
     */
    public function report()
    {
        return $this->belongsTo(Project::class,'report_id','id');
    }
    
    /**
     * Get the workflow profile.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }

}