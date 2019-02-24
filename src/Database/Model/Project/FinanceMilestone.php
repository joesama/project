<?php

namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\FinanceProgress;

class FinanceMilestone extends Model
{
	use SoftDeletes;
	
	protected $table = 'project_milestone_finance';
    protected $guarded = ['id'];
    protected $appends = ['planned_amount','actual_amount'];

    /**
     * Get the project info.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the card info.
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'card_id','id');
    }

    public function getPlannedAmountAttribute($value)
    {
        return number_format($this->attributes['planned'],2);
    }

    public function getActualAmountAttribute($value)
    {
        return number_format($this->attributes['actual'],2);
    }
    
    /**
     * Get the task's progress.
     */
    public function progress()
    {
        return  $this->hasOne(FinanceProgress::class,'finance_id')->latest();
    }
}
