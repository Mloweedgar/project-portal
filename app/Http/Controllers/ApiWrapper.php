<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\Core\Translator\TranslatorFactory;
use App\Models\Config;

/**
 * Class ApiWrapper
 * @package App\Http\Controllers
 */
class ApiWrapper extends Controller
{

    /**
     * Versions of the API, including latest
     * and deprecated versions.
     *
     * @var array
     */
    public $api_versions = array();

    /**
     * Latest API version only.
     *
     * @var float
     */
    public $api_version_latest;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {

        /**
         * The API Middleware, controls the access to the API
         * There are currently two limitations that prevents
         * the client to access the API:
         *
         * -> API Throttle:     Prevents the client to request more information if the client
         *                      has reached the maximum amount of requests per minute as stated
         *                      in the configuration file.
         *
         * -> API Access:       Prevents the client to request information if the API is offline.
         *                      The API can be set to Online or Offline at the backend of the application.
         *
         */
        $this->middleware("api.throttle");
        $this->middleware("api.access");

        /**
         * Load all the API version available.
         */
        $this->api_versions = array_values(array_diff(scandir(app_path('Http/Controllers/Api/Version')), array('.', '..')));

        /**
         * Retrieve latest API version.
         */
        $this->api_version_latest = (array) array_last($this->api_versions);

    }

    /**
     * This is the basic API entrance, here we are going to
     * deliver information of the publisher, licenses
     * and the location of the API documentation.
     *
     * @param null $version
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function loader($version = NULL)
    {

        /**
         * If the version is not provided, we always use
         * the latest version available.
         */
        if (!isset($version)){ $version = $this->api_version_latest[0]; }

        /**
         * Check that the provided version is valid,
         * TODO: Provide deprecation info if needed.
         */
        if($this->check_ValidVersion($version, $this->api_versions)){

            /**
             * Dynamic loading of the controller.
             * Version have to exists, if null provided, use latest version.
             */
            $controllerVersionNamespace = 'Api\Version\\' . $version . '\\ApiController.php';
            return new $controllerVersionNamespace($version, $arguments = array());

        } else {

            return responder()->error("api_version_not_found", "The API version provided does not exist.")->respond();

        }

    }

    /**
     * @param $version
     * @param $version_list
     * @return bool
     */
    private function check_ValidVersion($version, $version_list){

        if(!in_array($version, $version_list)){

            return false;

        }

        return true;

    }

    /**
     * Check API status.
     * The status of the API can be changed from the backend of the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_ApiStatus(){

        $configModel = new Config();
        $api_status = $configModel->where("name", "api")->pluck("value")->first();

        return responder()->success([
            'api-status' => (new TranslatorFactory)->translate($configModel, "api", $api_status, 2)
        ])->respond();

    }

    /**
     * Return all the API versions available
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_ApiVersionList(){

        return responder()->success($this->api_versions)->respond();

    }

    /**
     * Return the latest API version
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_ApiVersionLatest(){

        return responder()->success($this->api_version_latest)->respond();

    }

}
