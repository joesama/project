<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risk extends Model
{
    use SoftDeletes;
    
	protected $table = 'risk';
    protected $guarded = ['id'];

    /**
     * Get the task's project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the task's assignee.
     */
    public function assignee()
    {
        return $this->belongsTo(Profile::class,'profile_id','id');
    }

    /**
     * Get the task's progress.
     */
    public function severity()
    {
        return  $this->belongsTo(MasterData::class,'severity_id');
    }
    
    /**
     * Get the task's progress.
     */
    public function status()
    {
        return $this->belongsTo(MasterData::class,'status_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['assignee','severity','project','status']);
    }

}
