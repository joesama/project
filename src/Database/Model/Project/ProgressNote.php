<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Corporate;

class ProgressNote extends Model
{
	protected $table = 'progress_note';
    protected $guarded = ['id'];

    /**
     * Get all of the owning commentable models.
     */
    public function note()
    {
        return $this->morphTo();
    }
}
