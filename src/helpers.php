<?php

use Joesama\Project\Database\Model\Organization\Profile;


if (!function_exists('profile')) {

    /**
     * Get Origin IP.
     *
     *
     * @return string
     */
    function profile()
    {
        return Profile::where('user_id',auth()->id())->first();
    }
}

if (!function_exists('projectManager')) {

    /**
     * Get Origin IP.
     *
     *
     * @return string
     */
    function projectManager($projectId)
    {
        return Profile::where('user_id',auth()->id())->IsProjectManager($projectId)->first();
    }
}