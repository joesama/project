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
     * @param  [type]
     * @return [type]
     */
    public function scopeProgress($query)
    {
        return $query->whereHas('master',function($subquery){
        	$subquery->progress();
        });
    }

    /**
     * @param  [type]
     * @return [type]
     */
    public function scopeSeverity($query)
    {
        return $query->whereHas('master',function($subquery){
            $subquery->severity();
        });
    }

    /**
     * @param  [type]
     * @return [type]
     */
    public function scopeIncident($query)
    {
        return $query->whereHas('master',function($subquery){
        	$subquery->incident();
        });
    }

}
