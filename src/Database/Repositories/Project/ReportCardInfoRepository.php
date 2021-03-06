<?php
namespace Joesama\Project\Database\Repositories\Project;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Card;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Model\Project\PhysicalMilestone;
use Joesama\Project\Database\Model\Project\Report;
use Joesama\Project\Database\Model\Project\ReportWorkflow;
use Joesama\Project\Database\Model\Project\TagMilestone;
use Joesama\Project\Traits\HasAccessAs;

class ReportCardInfoRepository
{
   
    use HasAccessAs;
    
    private $reportObj, $cardObj;

    public function __construct(
        Report $report,
        Card $card
    ) {
        $this->reportObj = $report;
        $this->cardObj = $card;
        $this->profile = $this->profile();
    }

    /**
     * Get Monthly Report Information
     *
     * @param  int    $reportId Report Id
     * @return Joesama\Project\Database\Model\Project\Card
     */
    public function getMonthlyReportInfo(int $reportId)
    {
        return Card::where('id', $reportId)->isReported($reportId)->first();
    }

    /**
     * Get Weekly Report Information
     *
     * @param  int    $reportId Report Id
     * @return Joesama\Project\Database\Model\Project\Report
     */
    public function getWeeklyReportInfo(int $reportId)
    {
        return Report::where('id', $reportId)->isReported($reportId)->first();
    }

    /**
     * Get Monthly Report List
     *
     * @param  int      $corporateId Current User Corporate Id
     * @param  int|null $projectId   Current Project Id
     * @param  int|null $profileId   Current User Profile Id
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function monthlyList(int $corporateId, ?int $projectId = NULL, ?int $profileId = NULL)
    {
        return $this->cardObj->where(function ($query) use ($projectId, $profileId) {
            $query->when($projectId, function ($query, $projectId) {
                $query->whereHas('project',function($query) use($projectId){
                    return $query->where('id', $projectId);
                });
            });

            $query->when($profileId, function ($query, $profileId) {
                $query->where('need_action', $profileId);
            });

            $query->whereHas('project.profile',function($query) {
                $query->where('profile_id',$this->profile->id);
            });
        })->component()->paginate();
    }

    /**
     * Get Weekly Report List
     * 
     * @param  int      $corporateId Current User Corporate Id
     * @param  int|null $projectId Current Project Id
     * @param  int|null $profileId Current User Profile Id
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function weeklyList(int $corporateId, ?int $projectId = NULL, ?int $profileId = NULL)
    {
        return $this->reportObj->where(function ($query) use ($projectId, $profileId) {         
            $query->when($projectId, function ($query, $projectId) {
                $query->whereHas('project',function($query) use($projectId){
                    return $query->where('id', $projectId);
                });
            });

            $query->when($profileId, function ($query, $profileId) {
                $query->where('need_action', $profileId);
            });

			$query->whereHas('project.profile',function($query) {
				$query->where('profile_id',$this->profile->id);
			});
        })->component()->paginate();
    }


    /**
     * Monthly Report Workflow
     *
     * @param  int      $corporateId    Corporate Id
     * @param  string   $dateStart      Report Date Start
     * @param  string   $dateEnd        Report Date End
     * @param  Project  $project        Project Model
     * @return Collection
     */
    public function monthlyWorkflow(int $corporateId, string $dateStart, string $dateEnd, $project)
    {
        return collect(config('joesama/project::workflow.1'))->map(function ($role, $state) use ($corporateId, $dateStart, $dateEnd, $project) {

            $status = strtolower(MasterData::find($state)->description);

            if (in_array($state, [1,2])) {
                $profile = $project->profile->where('corporate_id', $project->corporate_id)->where('pivot.role_id', $role)->first();
            } else {
                $profile = $project->profile->where('corporate_id', 1)->where('pivot.role_id', $role)->first();
            }

            return [
                'status' => $status,
                'step' => $state,
                'monthly' => CardWorkflow::whereHas('card', function ($query) use ($project, $dateStart, $dateEnd) {
                                $query->where('project_id', $project->id);
                                $query->whereDate('card_date', $dateStart);
                                $query->whereDate('card_end', $dateEnd);
                })->where('state', $status)->with('card')->first(),
                'profile' => $profile
            ];
        });
    }

    /**
     * Weekly Report Workflow
     *
     * @param  int      $corporateId    Corporate Id
     * @param  string   $dateStart      Report Date Start
     * @param  string   $dateEnd        Report Date End
     * @param  Project  $project        Project Model
     * @return Collection
     */
    public function weeklyWorkflow(int $corporateId, string $dateStart, string $dateEnd, $project)
    {
        return collect(config('joesama/project::workflow.1'))->map(function ($role, $state) use ($corporateId, $dateStart, $dateEnd, $project) {

            $status = strtolower(MasterData::find($state)->description);

            if (in_array($state, [1,2])) {
                $profile = $project->profile->where('corporate_id', $project->corporate_id)->where('pivot.role_id', $role)->first();
            } else {
                $profile = $project->profile->where('corporate_id', 1)->where('pivot.role_id', $role)->first();
            }

            return [
                'status' => $status,
                'step' => $state,
                'weekly' => ReportWorkflow::whereHas('report', function ($query) use ($project, $dateStart, $dateEnd) {
                                $query->where('project_id', $project->id);
                                $query->whereDate('report_date', $dateStart);
                                $query->whereDate('report_end', $dateEnd);
                })->where('state', $status)->with('report')->first(),
                'profile' => $profile
            ];
        });
    }


    /**
     * List All Profile Involve In Project
     *
     * @param  Collection   $profile    Profile
     * @param  int          $projectId  Project Id
     * @return Collection
     */
    public function reportWorkflow($project, int $projectId)
    {
        return collect(config('joesama/project::workflow.1'))->mapWithKeys(function ($role, $state) use ($project, $projectId) {

            $status = strtolower(MasterData::find($state)->description);

            if (in_array($state, [1,2])) {
                $profile = $project->profile->where('corporate_id', $project->corporate_id)->where('pivot.role_id', $role)->first();
            } else {
                $profile = $project->profile->where('corporate_id', 1)->where('pivot.role_id', $role)->first();
            }
            
            $role = collect(data_get($profile, 'role'))->where('pivot.project_id', $projectId)->first();

            return [
                $status => [
                    'profile' => $profile,
                    'role' => $role
                ]
            ];
        });
    }

    /**
     * Schedule Payment
     *
     * @param  Collection $payment  All Payment Schedule For Project
     * @return Collection
     */
    public function scheduleTask(int $projectId)
    {
        $planned = collect([]);

        $actual = collect([]);

        $transaction = collect([]);

        $milestone = PhysicalMilestone::where('project_id', $projectId)->get();
        
        $latest = $milestone->filter(function ($miles) {
            return Carbon::parse($miles->progress_date)->endOfMonth()->equalTo(Carbon::now()->endOfMonth());
        })->first();

        return collect([
                'planned' => $milestone->pluck('planned')->prepend(0)->prepend('Planned'),
                'actual' => $milestone->pluck('actual')->prepend(0)->prepend('Actual'),
                'categories' => $milestone->pluck('label')->prepend([Carbon::parse($milestone->first()->label)->subMonth()->format('d M Y')]),
                'variance' => floatval(data_get($latest, 'actual')) - floatval(data_get($latest, 'planned')),
                'latest' => $latest,
            ]);
    }
} // END class ReportCardInfoRepository
