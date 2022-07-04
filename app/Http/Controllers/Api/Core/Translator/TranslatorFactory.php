<?php

namespace App\Http\Controllers\Api\Core\Translator;

use App\Http\Controllers\Api\Core\Translator\Translators\ConfigTranslator;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\Core\Translator\Src\TranslatorExceptions;

/**
 * Class TranslatorLoader
 * @package App\Http\Controllers\Api\Core\Translator
 */
class TranslatorFactory extends Controller
{

    /**
     * @param Model $location
     * @param string $key | Name of the column to search
     * @param string $value | Value of the column to translate
     * @param int $flavour | 1 -> columnValue | 2 -> customValue
     * @return string
     * @throws TranslatorExceptions
     */
    public function translate(Model $location, string $key, string $value, int $flavour): string
    {

        try {

            switch ($location){

                case $location instanceof Config: $out = (new ConfigTranslator)->load($key, $value, $flavour); break;

                default: throw new TranslatorExceptions("Invalid location parameter.");

            }

            return $out;

        } catch (TranslatorExceptions $e){

            return $e;

        }

    }

}
