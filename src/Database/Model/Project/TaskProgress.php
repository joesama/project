<?php
namespace Joesama\Project\Database\Model\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Project\Database\Model\Organization\Profile;

class TaskProgress extends Model
{
    use SoftDeletes;
    
	protected $table = 'task_progress';
    protected $fillable = ['progress'];
    /**
     * Get the card attach.
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'card_id','id');
    }

    /**
     * Get the report attach.
     */
    public function report()
    {
        return $this->belongsTo(Profile::class,'report_id','id');
    }

}
