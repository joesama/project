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

                $domainPath = 'joesama/project::'.str_replace('.', '/', $domain);

                if(collect($component)->get('list') != null){
                    $path = '/list';
                }else{
                    $path = '/'.collect($component)->keys()->first();
                }

                $segmentOne = '/'. data_get($this->profile,'corporate_id');

                if(!collect($component)->get('no_menu')){

                $menu->add($submodule,'^:'.$module)
                    ->title(trans('joesama/project::menu.'.$domain))
                    ->link(handles($domainPath.$path.$segmentOne))
                    ->icon('psi-arrow-right-2');
                    
                    collect($component)->each(function($params, $page) 
                        use($menu,$domain,$domainPath,$module,$submodule,$segmentOne){

                        $segmentTwo = '';

                        $masterId = collect($params)->contains('masterId');
                        $corporateId = collect($params)->contains('corporateId');
                        $projectIdOptional = collect($params)->contains('projectId?');
                        $projectIdRequired = collect($params)->contains('projectId');

                        if($projectIdRequired || $projectIdOptional || $masterId)
                        {
                            $segmentTwo .= '/'. request()->segment(5);
                        }

                        if($projectIdRequired)
                        {
                            $segmentTwo .= '/'. request()->segment(6);
                        }

                        $subdomainPath = $domainPath.'/'.$page.$segmentOne.$segmentTwo;
                        $subdomain = $submodule.'.'.$page;
                        
                        if(($projectIdOptional || $masterId ) && request()->segment(5) && $module == request()->segment(1))
                        {   
                            $menu->add($subdomain,'^:'.$domain)
                                ->title(trans('joesama/project::'.$domain.'.'.$page))
                                ->link(handles($subdomainPath));
                        }
                        elseif(!$projectIdOptional && !$projectIdRequired && !$masterId)
                        {
                            $menu->add($subdomain,'^:'.$domain)
                                ->title(trans('joesama/project::'.$domain.'.'.$page))
                                ->link(handles($subdomainPath));
                        }
                    });
                }
            });
        });
        // dd($menu);

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
