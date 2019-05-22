<?php
namespace Joesama\Project\Events\Handlers;

use Auth;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Traits\HasAccessAs;

class MenuHandler
{
    use HasAccessAs;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->profile = $this->profile();
        $this->webPolicies = collect(config('joesama/project::policy.web'));
    }

    /**
     * Handle User Insertion Event
     *
     * @param  entree.menu:ready $menu
     * @return void
     */
    public function handle($menu)
    {
        $this->webPolicies->each(function ($policy, $module) use ($menu) {
            if (!collect($policy)->get('no_menu', false)) {
                $menu->add($module, '>:config')
                ->title(trans('joesama/project::menu.'.$module.'.module'))
                ->link('#')
                ->icon(array_get($policy, 'icon'));

                collect($policy)->except('icon')->each(function ($component, $submodule) use ($menu,$module) {
                    $domain = $module.'.'.$submodule;

                    $domainPath = 'joesama/project::'.str_replace('.', '/', $domain);

                    if (collect($component)->get('list') != null) {
                        $path = '/list';
                    } else {
                        $path = '/'.collect($component)->keys()->first();
                    }

                    $segmentOne = '/'. data_get($this->profile, 'corporate_id');

                    if (!collect($component)->get('no_menu', false)) {
                        $menu->add($submodule, '^:'.$module)
                    ->title(trans('joesama/project::menu.'.$domain))
                    ->link(handles($domainPath.$path.$segmentOne))
                    ->icon('psi-arrow-right-2');
                    
                        collect($component)->each(function ($params, $page) use ($menu,$domain,$domainPath,$module,$submodule,$segmentOne) {
                            $segmentTwo = '';

                            $masterId = collect($params)->contains('masterId');
                            $corporateId = collect($params)->contains('corporateId');
                            $projectIdOptional = collect($params)->contains('projectId?');
                            $projectIdRequired = collect($params)->contains('projectId');

                            if ($projectIdRequired || $projectIdOptional || $masterId) {
                                $segmentTwo .= '/'. request()->segment(5);
                            }

                            if ($projectIdRequired) {
                                $segmentTwo .= '/'. request()->segment(6);
                            }

                            $subdomainPath = $domainPath.'/'.$page.$segmentOne.$segmentTwo;
                            $subdomain = $submodule.'.'.$page;
                        
                            if (($projectIdOptional || $masterId) && request()->segment(5) && $module == request()->segment(1)) {
                                $menu->add($subdomain, '^:'.$domain)
                                ->title(trans('joesama/project::'.$domain.'.'.$page))
                                ->link(handles($subdomainPath));
                            } elseif (!$projectIdOptional && !$projectIdRequired && !$masterId) {
                                $menu->add($subdomain, '^:'.$domain)
                                ->title(trans('joesama/project::'.$domain.'.'.$page))
                                ->link(handles($subdomainPath));
                            }
                        });
                    }
                });
            }
        });
    }
}
