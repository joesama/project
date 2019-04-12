<?php
namespace Joesama\Project\Database\Model\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;

class Report extends Model
{
	protected $table = 'project_report';
    protected $guarded = ['id'];
    protected $appends = ['generation_date'];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the card workflow status.
     */
    public function workflow()
    {
        return $this->hasMany(ReportWorkflow::class,'report_id','id');
    }

    /**
     * Get the report status.
     */
    public function status()
    {
        return $this->belongsTo(MasterData::class,'workflow_id','id');
    }

    /**
     * Get the report status.
     */
    public function creator()
    {
        return $this->belongsTo(Profile::class,'creator_id','id');
    }

    /**
     * Get the report status.
     */
    public function nextby()
    {
        return $this->belongsTo(Profile::class,'need_action','id');
    }

    public function scopeComponent($query)
    {
        return $query->with(['status','project','workflow']);
    }

    public function scopeReporting($query, $endDate)
    {
        return $query->with(['status','workflow'])
        ->with(['project' => function($query) use ($endDate){
            $query->with(['task'=> function($query) use ($endDate){
                $query->with(['progress'=> function($query) use ($endDate){
                    $query->where('created_at', '<=' ,$endDate);
                    $query->where(function ($query) {
                        $query->whereNull('report_id');
                    });
                }]);
            }]);
            $query->with(['payment'=> function($query) use ($endDate){
                $query->where('paid_date', '<=' ,$endDate);
                $query->where(function ($query) {
                        $query->whereNull('report_id');
                    });
            }]);
            $query->with(['plan'=> function($query) use ($endDate){
                $query->where('created_at', '<=' ,$endDate);
                $query->where(function ($query) {
                        $query->whereNull('report_id');
                    });
            }]);
            $query->with(['incident'=> function($query) use ($endDate){
                $query->where('incident_date', '<=' ,$endDate);
                $query->where(function ($query) {
                        $query->whereNull('report_id');
                    });
            }]);
        }]);
    }

    public function scopeIsReported($query, $reportId)
    {
        return $query->with(['status','workflow'])
        ->with(['project' => function($query) use ($reportId){
            $query->with(['task'=> function($query) use ($reportId){
                $query->with(['progress'=> function($query) use ($reportId){
                    $query->where('report_id', $reportId);
                }]);
            }]);
            $query->with(['payment'=> function($query) use ($reportId){
                $query->where('report_id', $reportId);
            }]);
            $query->with(['plan'=> function($query) use ($reportId){
                $query->where('report_id', $reportId);
            }]);
            $query->with(['incident'=> function($query) use ($reportId){
                $query->where('report_id', $reportId);
            }]);
        }]);
    }

    public function getGenerationDateAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }

}
