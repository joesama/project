<?php

namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Corporate;

class ProjectUpload extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_upload';
    protected $guarded = ['id'];
    protected $appends = ['aging'];

    /**
     * Get the project info.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function getAgingAttribute($value)
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

}
