<?php

namespace App\Http\Controllers\Api\Core\Translator\Src;

/**
 * Interface TranslatorInterface
 * @package App\Http\Controllers\Api\Core\Translator\Src
 */
interface TranslatorInterface
{

    /**
     * Loader for each type of translation flavour.
     *
     * @param string $key
     * @param string $value
     * @param int $flavour
     * @return string
     */
    function load(string $key, string $value, int $flavour): string;

    /**
     * Translator relative to the model mapping.
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    function columnValue(string $key, string $value): string;

    /**
     * Translator for custom values and data-sets without model mapping.
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    function customValue(string $key, string $value): string;

}