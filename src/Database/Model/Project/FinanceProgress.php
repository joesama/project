<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\FinanceMilestone;

class FinanceProgress extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_finance_progress';
    protected $guarded = ['id'];

    /**
     * Get the project info.
     */
    public function milestone()
    {
        return $this->belongsTo(FinanceMilestone::class,'finance_id','id');
    }

    /**
     * Get the card info.
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'card_id','id');
    }

}
