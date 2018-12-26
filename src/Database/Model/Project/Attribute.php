<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;

class Attribute extends Model
{
	protected $table = 'project_attribute';
    protected $guarded = ['id'];

    /**
     * Get the project info.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

}
