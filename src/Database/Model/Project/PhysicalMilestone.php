<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Project\Card;

class PhysicalMilestone extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_milestone_physical';
    protected $guarded = ['id'];

    /**
     * Get the project info.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the card info.
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'card_id','id');
    }

}
