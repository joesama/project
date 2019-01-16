<?php

namespace Joesama\Project\Database\Model\Organization;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Project\Client;

class Corporate extends Model
{
	protected $table = 'corporate';
    protected $guarded = ['id'];

    /**
     * Get the subsidiary for the corporate.
     */
    public function subsidiary()
    {
        return $this->hasMany(Corporate::class,'child_to','id');
    }

    /**
     * Get the parent for the corporate.
     */
    public function parent()
    {
        return $this->belongsTo(Corporate::class,'child_to','id');
    }

   /**
     * Get the report progress.
     */
    public function scopeIsParent($query)
    {
        return $this->whereNull('child_to');
    }

    /**
     * Get the address for the corporate.
     */
    public function address()
    {
        return $this->hasMany(CorporateAddress::class,'corporate_id','id');
    }

   /**
     * Get the  client partner for project.
     */
    public function client()
    {
        return $this->belongsToMany(Client::class,'corporate_client','corporate_id','client_id');
    }

}
