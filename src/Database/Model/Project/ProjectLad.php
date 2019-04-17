<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class ProjectLad extends Model
{
	protected $table = 'project_lad';
    protected $guarded = ['id'];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the claim reporter.
     */
    public function reporter()
    {
        return $this->belongsTo(Profile::class,'report_by','user_id');
    }

    /**
     * Get all of the tags for the milstone.
     */
    public function recipient()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function getDateAttribute($value)
    {
        return (is_null($value)) ? $value : Carbon::parse($value)->format('d-m-Y');
    }

    public function scopeComponent($query)
    {
        return $query->with(['reporter','project','recipient']);
    }

}
