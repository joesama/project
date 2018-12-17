<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'project_report';

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the card workflow status.
     */
    public function workflow()
    {
        return $this->belongsTo(CardWorkflow::class,'workflow_id','id');
    }

}
