<?php
namespace Joesama\Project\Database\Model\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Joesama\Entree\Database\Model\Logs\NotificationLog;
use Joesama\Entree\Database\Model\User;
use Joesama\Entree\Http\Notifications\EntreeMailer;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\Project;

class Profile extends Model
{
    use Notifiable;

	protected $table = 'profile';
    protected $guarded = ['id'];

    /**
     * Get the corporate.
     */
    public function corporate()
    {
        return $this->belongsTo(Corporate::class,'corporate_id','id');
    }

    /**
     * Get the position.
     */
    public function position()
    {
        return $this->belongsTo(MasterData::class,'position_id','id');
    }

    /**
     * Get the project profile.
     */
    public function project()
    {
        return $this->belongsToMany(Project::class,'project_role','profile_id','project_id');
    }

    /**
     * Get the project profile.
     */
    public function role()
    {
        return $this->belongsToMany(ProfileRole::class,'project_role','profile_id','role_id')->withPivot('project_id');
    }

    /**
     * Get the profile user.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * set profile in same group filter.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSameGroup($query,$corporateId)
    {
        return $this->where('corporate_id',$corporateId)->nonAdmin();
    }

    /**
     * set profile from parent org filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromParent($query)
    {
        return $this->whereHas('corporate',function($query){
            $query->isParent();
        })->nonAdmin();
    }

    /**
     * set cross organization filter.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCrossOrganization($query)
    {
        return $this->nonAdmin();
    }

    /**
     * Set non admin filter.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonAdmin($query)
    {
        return $this->whereHas('user',function($query){
            $query->where('isAdmin','!=',1);
        });
    }

    /**
     * Set non admin filter.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin($query)
    {
        return $this->whereHas('user',function($query){
            $query->where('isAdmin',1);
        });
    }

    public function scopeComponent($query)
    {
        return $query->with([
            'project.role','corporate','user','position','mails'
        ]);
    }

    public function scopeIsProjectManager($query,$projectId)
    {
        return $query->role()->where('project_id',$projectId)->where('role_id',2);
    }

    public function getFullnameAttribute($value)
    {
        return $this->name;
    }

    /**
     * Get all of the user's mail.
     */
    public function mails()
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }

    /**
     * Send the profile notification for action.
     * 
     * @param  string $type Type Of Report
     * @return [type]       [description]
     */
    public function sendActionNotification($project, $report, string $type)
    {
        $message = collect([]);
        $message->put('level', 'warning');
        $message->put('title', trans('joesama/project::mailer.title.'.$type));

        if( !in_array( $type, array_map('strtolower',['weekly']) ) ) {
            $message->put('content', collect([
                title_case(trans('joesama/project::mailer.project.'.$type)),
                trans('joesama/project::mailer.report.project', ['project' => ucwords($project->name) ]),
            ]));

            
            if($type == 'monthly' || $type == 'info' ){
                $param = $project->corporate_id.'/'.$project->id.'/'.$report->id;
            }else{
                $param = $project->corporate_id.'/'.$project->id;
            }

            $appname = memorize('threef.' .\App::getLocale(). '.name', config('app.name'));

            $path = handles('joesama/entree::manager/project/view/'.$param);

            if($type == 'info' ){
                $path = handles('joesama/entree::manager/project/info/'.$param);
            }

            $message->put('action', collect([ $appname => $path ]));

        }else{

            $message->put('content', collect([
                title_case(trans('joesama/project::mailer.report.success')),
                trans('joesama/project::mailer.report.project', ['project' => ucwords($project->name) ]),
                trans('joesama/project::mailer.report.report', [
                    'type' => strtoupper($type) ,
                    'report' => strtoupper(data_get($report,'week',data_get($report,'month')))
                ]),
            ]));

            $message->put('action', collect([
                memorize('threef.' .\App::getLocale(). '.name', config('app.name')) 
                => 
                handles('joesama/entree::report/'.$type.'/form/'.$project->corporate_id.'/'.$project->id.'/'.$report->id)
            ]));


        }

        $message->put('footer', collect([
            title_case(trans('joesama/entree::mail.validated.form')),
        ]));

        $this->notify(new EntreeMailer($message));
    }

    /**
     * Send the profile notification for success.
     * 
     * @param  string $type Type Of Report
     * @return [type]       [description]
     */
    public function sendAcceptedNotification($project, $report, string $type)
    {
        $message = collect([]);
        $message->put('level', 'success');
        $message->put('title', trans('joesama/project::mailer.title.'.$type));

        if(!in_array( $type, array_map('strtolower',['weekly']) ) ){
            $message->put('content', collect([
                title_case(trans('joesama/project::mailer.project.'.$type)),
                trans('joesama/project::mailer.report.project', ['project' => ucwords($project->name) ]),
            ]));

            if($type == 'monthly'){
                $param = $project->corporate_id.'/'.$project->id.'/'.$report->id;
            }else{
                $param = $project->corporate_id.'/'.$project->id;
            }

            $message->put('action', collect([
                memorize('threef.' .\App::getLocale(). '.name', config('app.name')) 
                => 
                handles('joesama/entree::manager/project/view/'.$param)
            ]));

        }else{
            $message->put('content', collect([
                title_case(trans('joesama/project::mailer.report.success')),
                trans('joesama/project::mailer.report.project', ['project' => ucwords($project->name) ]),
                trans('joesama/project::mailer.report.report', [
                    'type' => strtoupper($type) ,
                    'report' => strtoupper(data_get($report,'week',data_get($report,'month')))
                ]),
            ]));

            $message->put('action', collect([
                memorize('threef.' .\App::getLocale(). '.name', config('app.name')) 
                => 
                handles('joesama/entree::report/'.$type.'/form/'.$project->corporate_id.'/'.$project->id.'/'.$report->id)
            ]));
        }

        $message->put('footer', collect([
            title_case(trans('joesama/entree::mail.validated.form')),
        ]));

        $this->notify(new EntreeMailer($message));
    }

}
