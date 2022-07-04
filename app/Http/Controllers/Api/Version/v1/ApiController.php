<?php

namespace App\Http\Controllers\Api\Version\v1;

use App\Http\Controllers\ApiWrapper;

/**
 * Class ApiController
 * @package App\Http\Controllers\Api\Version\v1
 */
class ApiController extends ApiWrapper
{

    const API_VERSION = "v1";

    public function __construct($version, $args = array())
    {

        parent::__construct();

        $api_version = self::API_VERSION;
        $client_api_version = $version;

        parent::middleware("api.authorizedVersion:api_version:client_api_version");

        return $this->index();

    }

    public function index(){

        return responder()->success(array(self::API_VERSION))->respond();

    }

    /**
     * Return the API publisher data following
     * the OCDS scheme.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_Publisher_Data() {

        return responder()->success(
            array(
                'scheme' => env("APP_URL"),
                'name' => env("OCDS_NAME"),
                'uri' => env("OCDS_URI"),
                'uid' => env("OCDS_UID")
            )
        )->respond();

    }

}
