<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\ProgressNote;

class Issue extends Model
{
    use SoftDeletes;
    
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
     * Get the issue's progress.
     */
    public function progress()
    {
        return  $this->belongsTo(MasterData::class,'progress_id');
    }

    /**
     * Get the issue's indicator.
     */
    public function indicator()
    {
        return  $this->belongsTo(MasterData::class,'indicator_id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['assignee','progress','project','indicator']);
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

    /**
     * Get all of the issue's notes.
     */
    public function notes()
    {
        return $this->morphMany(ProgressNote::class, 'note');
    }

}
