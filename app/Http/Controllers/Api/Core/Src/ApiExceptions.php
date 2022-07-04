<?php

namespace App\Http\Controllers\Api\Core\Src;

use Exception;

/**
 * Class ApiExceptions
 * @package App\Http\Controllers\Api\Core\Src
 */
class ApiExceptions extends Exception
{

    /**
     * ApiExceptions constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 0) {

        parent::__construct($message, $code);

    }

    /**
     * @return string
     */
    public function __toString() {

        return "Exception: [{$this->code}]: {$this->message}";

    }

}
