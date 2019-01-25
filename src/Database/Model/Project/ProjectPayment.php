<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\FinanceMilestone;

class ProjectPayment extends Model
{
	protected $table = 'project_payment';
    protected $guarded = ['id'];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the claim reporter.
     */
    public function creporter()
    {
        return $this->belongsTo(Profile::class,'claim_report_by','user_id');
    }

    /**
     * Get the payment reporter.
     */
    public function preporter()
    {
        return $this->belongsTo(Profile::class,'paid_report_by','user_id');
    }

    /**
     * Get the payment milestone.
     */
    public function milestone()
    {
        return $this->belongsToMany(FinanceMilestone::class,'milestone_payment','payment_id','milestone_id');
    }

    public function getClaimDateAttribute($value)
    {
        return (is_null($value)) ? $value : Carbon::parse($value)->format('d-m-Y');
    }

    public function getPaymentDateAttribute($value)
    {
        return (is_null($value)) ? $value : Carbon::parse($value)->format('d-m-Y');
    }

    public function scopeComponent($query)
    {
        return $query->with(['creporter','preporter','project','milestone']);
    }


}
