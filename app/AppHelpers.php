<?php
/**
 * Get Country Code
 *
 * @return string
 */
function getAppName()
{
    return env('APP_NAME');
}

function getAppTitle(){
    return env('APP_TITLE');
}

/**
 * Get Country Code
 *
 * @return string
 */
function getCountryCode()
{
    return env('APP_ISO');
}
/**
 * Is Zanzibar PPP site running?
 *
 * @return bool
 */
function isZanzibarPPP()
{
    return (env('APP_NAME') === 'ZanzibarPPP');
}
/**
 * Get alphanumeric password with special chars
 *
 * @return string (4 char min)
 */

function generatePassword(Int $length = 8)
{
    $pool = [
        "abcdefghijklmnopqrstuvwxyz",
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        "0123456789",
        "!@#$%^&*()_-=+?"
    ];
    $password = "";


    // at least one of each
    foreach($pool as $str){
        $password  .= substr($str,  rand(0, strlen($str)  - 1), 1);
    }

    $remain = $length - count($pool);

    if($remain > 0){
        $str = implode($pool);
        $len = strlen($str) - 1;

        for($i = 0; $i < $remain; $i++){
            $password .= substr($str, rand(0, $len), 1);
        }
    }

    return  str_shuffle($password);

}
