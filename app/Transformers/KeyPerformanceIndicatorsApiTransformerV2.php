<?php

namespace App\Transformers;

use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator;
use Flugg\Responder\Transformers\Transformer;

class KeyPerformanceIndicatorsApiTransformerV2 extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = ['*'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param PI_KeyPerformanceIndicator $pI_KeyPerformanceIndicator
     * @return array
     * @internal param \App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicatorMain $pI_KeyPerformanceIndicatorMain
     */
    public function transform(PI_KeyPerformanceIndicator $pI_KeyPerformanceIndicator)
    {
        $out = array();
        $out['id'] = (string) $pI_KeyPerformanceIndicator->id;
        $out['title'] = $pI_KeyPerformanceIndicator->type->name . " (" . $pI_KeyPerformanceIndicator->type->unit . ")";
        $out['observations'][0]['id'] = (string) $pI_KeyPerformanceIndicator->id;
        $out['observations'][0]['period']['startDate'] = (new \DateTime($pI_KeyPerformanceIndicator->year))->format('c');
        $out['observations'][0]['value']['amount'] = (int) $pI_KeyPerformanceIndicator->target;
        $out['observations'][0]['measure'] = $pI_KeyPerformanceIndicator->achievement;

        return $out;
    }
}
