<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
	use SoftDeletes;
	
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
