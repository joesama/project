<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $table = 'client';

    /**
     * Get the partner list.
     */
    public function partner()
    {
        return $this->hasMany(ClientPartner::class,'client_id','id');
    }

}
