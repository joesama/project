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

        $menu->add('license','>:config')
            ->title(trans('joesama/project::project.module'))
            ->link('#')
            ->icon('icon fa fa-qrcode');

    }



}
