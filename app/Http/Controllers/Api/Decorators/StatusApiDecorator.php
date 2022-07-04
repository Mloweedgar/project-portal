<?php

namespace App\Http\Controllers\Api\Decorators;

use App\Models\Config;
use Flugg\Responder\Http\Responses\Decorators\ResponseDecorator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\Core\Translator\TranslatorFactory;

/**
 * A decorator class for adding status code information to the response data.
 *
 * Class StatusApiDecorator
 * @package App\Http\Controllers\Api\Decorators
 */
class StatusApiDecorator extends ResponseDecorator
{
    /**
     * Generate a JSON response.
     *
     * @param  array $data
     * @param  int   $status
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function make(array $data, int $status, array $headers = []): JsonResponse
    {
        $configModel = new Config();
        $api_status = $configModel->where("name", "api")->pluck("value")->first();

        return $this->factory->make(array_merge([
            'api-status' => (new TranslatorFactory)->translate($configModel, "api", $api_status, 2)
        ], $data), $status, $headers);
    }

}
