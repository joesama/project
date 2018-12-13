<?php

namespace Joesama\Project\Database\Model\Organization;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table = 'profile';

    /**
     * Get the corporate.
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }
}
