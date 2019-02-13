<?php 
namespace Joesama\Project\Events\Subscriber;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {

    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        session()->flush();
        session()->regenerate();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'Joesama\Project\Events\Subscriber\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'Joesama\Project\Events\Subscriber\UserEventSubscriber@onUserLogout'
        );
    }
}