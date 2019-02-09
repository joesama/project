<?php
namespace Joesama\Project\Database\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;

class MasterData extends Model
{
	protected $table = 'master_data';
    protected $guarded = ['id'];


	/**
     * Get the master relation
     */
    public function master()
    {
        return $this->belongsTo(Master::class,'master_id','id');
    }

    /**
     * Query Progress Data List]
     */
    public function scopeProgress($query)
    {
        return $query->whereHas('master',function($subquery){
        	$subquery->progress();
        });
    }

    /**
     * Query Severity Data List
     */
    public function scopeSeverity($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->severity();
        });
    }

    /**
     * Query Incident Data List
     */
    public function scopeIncident($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->incident();
        });
    }

    /**
     * Query Position Data List
     */
    public function scopePosition($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->position();
        });
    }

    /**
     * Query Status Data List
     */
    public function scopeStatus($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->status();
        });
    }

    /**
     * Query Active Data List
     */
    public function scopeActive($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->active();
        });
    }

    /**
     * Query Issue Indicator Data List
     */
    public function scopeIndicator($query)
    {
        return $query->whereHas('master',function($subquery){
        	$subquery->indicator();
        });
    }

}
