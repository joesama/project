<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class CardWorkflow extends Model
{
	protected $table = 'project_card_workflow';

    /**
     * Get the workflow card.
     */
    public function card()
    {
        return $this->belongsTo(Project::class,'card_id','id');
    }
    
    /**
     * Get the workflow profile.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }

}