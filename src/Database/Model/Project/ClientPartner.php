<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ClientPartner extends Model
{
	protected $table = 'client_partner';

    /**
     * Get the subsidiary for the corporate.
     */
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }

    /**
     * The project that belong to the partner.
     */
    public function project()
    {
        return $this->belongsToMany(Project::class);
    }

}
