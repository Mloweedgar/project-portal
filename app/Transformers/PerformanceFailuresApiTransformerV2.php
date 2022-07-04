<?php

namespace App\Transformers;


use App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure;
use Flugg\Responder\Transformers\Transformer;

class PerformanceFailuresApiTransformerV2 extends Transformer
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
     * @param  \App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure $PI_PerformanceFailure
     * @return array
     */
    public function transform(PI_PerformanceFailure $PI_PerformanceFailure)
    {
        if($PI_PerformanceFailure->published){
            return [
                'id' => (string) $PI_PerformanceFailure->id,
                'category' => $PI_PerformanceFailure->category->name,
                'events' => $PI_PerformanceFailure->number_events,
                'penaltyImposed' => $PI_PerformanceFailure->penalty_imposed,
                'penaltyPaid' => (bool)$PI_PerformanceFailure->penalty_paid
            ];
        } else {
            return array();
        }

    }
}
