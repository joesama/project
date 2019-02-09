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
     * Status Definition
     */
    public function scopeStatus($query)
    {
        return $query->where('id', 1);
    }

    /**
     * Progress Definition
     */
    public function scopeProgress($query)
    {
        return $query->where('id', 2);
    }

    /**
     * Progress Definition
     */
    public function scopeSeverity($query)
    {
        return $query->where('id', 3);
    }

    /**
     * Incident Definition
     */
    public function scopeIncident($query)
    {
        return $query->where('id', 4);
    }

    /**
     * Position Definition
     */
    public function scopePosition($query)
    {
        return $query->where('id', 5);
    }

    /**
     * Active Definition
     */
    public function scopeActive($query)
    {
        return $query->where('id', 6);
    }

    /**
     * Indicator Definition
     */
    public function scopeIndicator($query)
    {
        return $query->where('id', 7);
    }
}
