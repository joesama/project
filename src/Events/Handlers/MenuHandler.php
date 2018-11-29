<?php 
namespace Joesama\Project\Events\Handlers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MenuHandler
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle User Insertion Event
     *
     * @param  entree.menu:ready $menu
     * @return void
     */
    public function handle($menu)
    {
        $projectId = request()->segment(3);

        $menu->add('project','>:config')
            ->title(trans('joesama/project::project.module'))
            ->link('#')
            ->icon('icon fa fa-qrcode');

        $menu->add('project-dashboard','^:project')
            ->title(trans('joesama/project::project.dashboard'))
            ->link(handles('joesama/project::dashboard'))
            ->icon('icon fa fa-qrcode');

        if(!is_null($projectId) && request()->segment(1) == 'project' && is_integer(intval($projectId))){

            $menu->add('info','^:project')
                ->title(trans('joesama/project::project.detail'))
                ->link(handles('joesama/project::project/info/'.$projectId))
                ->icon('fas fa-info');

            $menu->add('summary','^:project.info')
                ->title(trans('joesama/project::project.detail'))
                ->link(handles('joesama/project::project/info/'.$projectId))
                ->icon('fas fa-file-alt');

            $menu->add('task','^:project.info')
                ->title(trans('joesama/project::project.task.task'))
                ->link(handles('joesama/project::project/task/'.$projectId))
                ->icon('fas fa-list-ul');

            $menu->add('physical','^:project.info')
                ->title(trans('joesama/project::project.scurve.physical'))
                ->link(handles('joesama/project::project/physical/'.$projectId))
                ->icon('fas fa-list-ul');

            $menu->add('financial','^:project.info')
                ->title(trans('joesama/project::project.scurve.financial'))
                ->link(handles('joesama/project::project/financial/'.$projectId))
                ->icon('fas fa-list-ul');

            $menu->add('issues','^:project.info')
                ->title(trans('joesama/project::project.issues.name'))
                ->link(handles('joesama/project::project/issues/'.$projectId))
                ->icon('fas fa-list-ul');
        }


    }



}
