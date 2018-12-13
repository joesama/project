<?php

namespace Joesama\Project\Database\Model\Organization;

use Illuminate\Database\Eloquent\Model;

class CorporateAddress extends Model
{
	protected $table = 'corporate_address';

    /**
     * Get the subsidiary for the corporate.
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

    /**
     * Get the subsidiary for the corporate.
     */
    public function state()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

}
