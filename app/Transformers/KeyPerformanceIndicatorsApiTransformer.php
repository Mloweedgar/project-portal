<?php

namespace App\Transformers;

use App\Models\Project\PerformanceInformation\KeyPerformanceIndicators\PI_KeyPerformanceIndicator;
use Flugg\Responder\Transformers\Transformer;

class KeyPerformanceIndicatorsApiTransformer extends Transformer
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
        return [
            'id' => (int) $pI_KeyPerformanceIndicator->id,
            'type' => $pI_KeyPerformanceIndicator->type->name . " (" . $pI_KeyPerformanceIndicator->type->unit . ")",
            'year' => $pI_KeyPerformanceIndicator->year,
            'target' => $pI_KeyPerformanceIndicator->target,
            'achievement' => $pI_KeyPerformanceIndicator->achievement
        ];
    }
}
