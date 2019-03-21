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
        return $this->nonAdmin()->where('corporate_id',$corporateId);
    }

    /**
     * set profile from parent org filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromParent($query)
    {
        return $this->nonAdmin()->whereHas('corporate',function($query){
            $query->isParent();
        });
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
     * @param  Project $project  Current Project
     * @param          $workflow Process Workflow
     * @param  string  $type     Type Of Workflow
     * @param  string  $level    Email Status
     * @return [type]            [description]
     */
    public function sendActionNotification(Project $project, $workflow, string $type, ?string $level = 'success')
    {
        $message = collect([]);
        $message->put('level', $level);

        $message->put('title', trans('joesama/project::mailer.title.'.$type));

        $message->put('content', collect([
            title_case(trans_choice('joesama/project::mailer.project.'.$type,
                $workflow->workflow->count(),
                ['state' => title_case($workflow->state)]
            )
            ),
            trans('joesama/project::mailer.report.project', ['project' => ucwords($project->name) ]),
        ]));

        $message->put('action', collect([
            memorize('threef.' .\App::getLocale(). '.name', config('app.name')) 
            => 
            handles('joesama/project::manager/project/view/'.$project->corporate_id.'/'.$project->id)
        ]));

        $message->put('footer', collect([
            title_case(trans('joesama/entree::mail.validated.form')),
        ]));

        $this->notify(new EntreeMailer($message));
    }
}
