<?php

namespace App\Http\Controllers\Api\Core\Translator\Translators;

use App\Http\Controllers\Api\Core\Translator\Src\TranslatorInterface;
use App\Http\Controllers\Api\Core\Translator\TranslatorFactory;
use App\Http\Controllers\Api\Core\Translator\Src\TranslatorExceptions;

/**
 * Class TranslatorLoader
 * @package App\Http\Controllers\Api\Core\Translator
 */
class ConfigTranslator extends TranslatorFactory implements TranslatorInterface
{
    /**
     * @param string $key
     * @param string $value
     * @param int $flavour
     * @return string
     */
    public function load(string $key, string $value, int $flavour): string
    {

        try{

            switch ($flavour){

                case 1: $out = $this->columnValue($key, $value); break;
                case 2: $out = $this->customValue($key, $value); break;

                default: throw new TranslatorExceptions("Invalid flavour parameter.");

            }

            return $out;


        } catch (TranslatorExceptions $e) {

            return $e;

        }

    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     * @throws TranslatorExceptions
     */
    public function columnValue(string $key, string $value): string
    {

        switch ($key){

            case 'name': $out = $value; break;
            case 'value': $out = $value; break;
            default: throw new TranslatorExceptions("Invalid column parameter.");

        }

        return $out;

    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     * @throws TranslatorExceptions
     */
    public function customValue(string $key, string $value): string
    {

        switch ($key){

            case 'api': $out = $this->api_customValue($value); break;
            default: throw new TranslatorExceptions("Invalid custom parameter.");

        }

        return $out;

    }

    /**
     * @param string $value
     * @return string
     * @internal param string $key
     */
    private function api_customValue(string $value): string
    {

        switch ($value){

            case '0': $out = 'Offline'; break;
            case '1': $out = 'Online'; break;

            default: $out = '';

        }

        return $out;

    }

}
