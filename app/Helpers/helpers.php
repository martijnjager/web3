<?php

if(!function_exists('route_active'))
{
    function route_active($route) {
        if(strpos(Route::currentRouteName(), $route) !== false)
            return 'active';

        return '';
    }
}
