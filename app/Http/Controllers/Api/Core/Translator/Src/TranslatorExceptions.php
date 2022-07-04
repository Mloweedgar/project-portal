<?php

namespace App\Http\Controllers\Api\Core\Translator\Src;

use Exception;

/**
 * Class TranslatorExceptions
 * @package App\Http\Controllers\Api\Core\Translator\Src
 */
class TranslatorExceptions extends Exception
{

    /**
     * TranslatorExceptions constructor.
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
