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

            $menu->add('report','^:project.info')
                ->title(trans('joesama/project::project.report.title'))
                ->link(handles('joesama/project::report/project/'.$projectId))
                ->icon('fa fa-file-word-o');
        }




    }



}
