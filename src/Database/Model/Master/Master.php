<?php
namespace Joesama\Project\Database\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
	protected $table = 'master';
    protected $guarded = ['id'];

	/**
     * Get the master data
     */
    public function data()
    {
        return $this->hasMany(MasterData::class,'master_id','id');
    }

    /**
     * Progress Definition
     */
    public function scopeProgress($query)
    {
        return $query->where('id', 1);
    }

    /**
     * Progress Definition
     */
    public function scopeSeverity($query)
    {
        return $query->where('id', 2);
    }

    /**
     * Incident Definition
     */
    public function scopeIncident($query)
    {
        return $query->where('id', 3);
    }
}
