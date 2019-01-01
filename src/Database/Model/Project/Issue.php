<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class Issue extends Model
{
	protected $table = 'issue';
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
    public function progress()
    {
        return  $this->belongsTo(MasterData::class,'progress_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['assignee','progress','project']);
    }

   /**
     * Get the issue progress.
     * @TODO should get the latest progress
     */
    public function scopeComplete($query)
    {
        return $query->where('active',0);
    }

   /**
     * Get the issue progress.
     * @TODO should get the latest progress
     */
    public function scopeOpen($query)
    {
        return $query->where('active',1);
    }

}
