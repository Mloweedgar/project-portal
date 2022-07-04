<?php

namespace App\Http;

class helpers
{
    /**
     * The helpers file
     *
     * These class helps to add custom function that can be use in the whole application
     * It's loaded in the composer.json file
     */


    /**
     * Return nav-here if current path begins with this path.
     *
     * @param string $path
     * @return string
     */
    function setActive($path)
    {
        return Request::is($path . '*') ? ' active' :  '';
    }
}
