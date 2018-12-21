<?php 
namespace Joesama\Project\Events\Handlers;

use Auth;
use Joesama\Project\Database\Model\Organization\Profile;

class MenuHandler
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->profile = Profile::where('user_id',Auth::id())->first();
        $this->webPolicies = collect(collect(config('packages/joesama/project/policy'))->get('web'));
    }

    /**
     * Handle User Insertion Event
     *
     * @param  entree.menu:ready $menu
     * @return void
     */
    public function handle($menu)
    {

        $this->webPolicies->each(function($policy,$module) use($menu){

            $menu->add($module,'>:config')
                ->title(trans('joesama/project::menu.'.$module.'.module'))
                ->link('#')
                ->icon(array_get($policy,'icon'));

            collect($policy)->except('icon')->each(function($component,$submodule) use($menu,$module){

                $domain = $module.'.'.$submodule;

                $path = 'joesama/project::'.str_replace('.', '/', $domain);

                if(collect($component)->get('list') != null){
                    $path .= '/list';
                }else{
                    $path .= '/'.collect($component)->keys()->first();
                }

                $path .= '/'. data_get($this->profile,'corporate_id');

                $menu->add($domain,'^:'.$module)
                    ->title(trans('joesama/project::menu.'.$domain))
                    ->link(handles($path))
                    ->icon('psi-arrow-right-2');

                // collect($component)->each(function($params, $page) use($menu,$domain,$path,$submodule){
                //     if(collect($params)->contains('projectId')){
                //         $path .= '/'. request()->segment(6);
                //     }

                //     $subdomain = $submodule.'.'.$page;
                //     $menu->add($subdomain,'^:'.$domain)
                //         ->title(trans('joesama/project::menu.'.$subdomain))
                //         ->link(handles($path))
                //         ->icon('psi-arrow-right-2');
                // });

            });
        });

        $projectId = request()->segment(3);

        // $menu->add('project','>:config')
        //     ->title(trans('joesama/project::project.module'))
        //     ->link('#')
        //     ->icon('icon fa fa-qrcode');

        // $menu->add('project-dashboard','^:project')
        //     ->title(trans('joesama/project::project.dashboard.overall'))
        //     ->link(handles('joesama/project::dashboard'))
        //     ->icon('icon fa fa-qrcode');

        if(!is_null($projectId) && in_array(request()->segment(1),['report','project']) && is_integer(intval($projectId))){

            $menu->add('info','^:project')
                ->title(trans('joesama/project::project.detail'))
                ->link(handles('joesama/project::project/info/'.$projectId))
                ->icon('fa fa-folder');

            $menu->add('summary','^:project.info')
                ->title(trans('joesama/project::project.detail'))
                ->link(handles('joesama/project::project/info/'.$projectId))
                ->icon('fa fa-file-word-o');

            $menu->add('task','^:project.info')
                ->title(trans('joesama/project::project.task.task'))
                ->link(handles('joesama/project::project/task/'.$projectId))
                ->icon('fa fa-list-ul');

            $menu->add('physical','^:project.info')
                ->title(trans('joesama/project::project.scurve.physical'))
                ->link(handles('joesama/project::project/physical/'.$projectId))
                ->icon('psi-line-chart');

            $menu->add('financial','^:project.info')
                ->title(trans('joesama/project::project.scurve.financial'))
                ->link(handles('joesama/project::project/financial/'.$projectId))
                ->icon('psi-line-chart');

            $menu->add('issues','^:project.info')
                ->title(trans('joesama/project::project.issues.name'))
                ->link(handles('joesama/project::project/issues/'.$projectId))
                ->icon('pli-overtime');

            $menu->add('issues','^:project.info')
                ->title(trans('joesama/project::project.risk.name'))
                ->link(handles('joesama/project::project/risk/'.$projectId))
                ->icon('pli-overtime');

            $menu->add('report','^:project.info')
                ->title(trans('joesama/project::project.report.title'))
                ->link(handles('joesama/project::report/project/'.$projectId))
                ->icon('fa fa-file-word-o');
        }




    }



}
