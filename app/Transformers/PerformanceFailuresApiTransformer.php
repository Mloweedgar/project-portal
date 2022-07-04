<?php

namespace App\Transformers;


use App\Models\Project\PerformanceInformation\PerformanceFailures\PI_PerformanceFailure;
use Flugg\Responder\Transformers\Transformer;

class PerformanceFailuresApiTransformer extends Transformer
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
                'id' => (int) $PI_PerformanceFailure->id,
                'name' => $PI_PerformanceFailure->title,
                'category' => $PI_PerformanceFailure->category->name,
                'numberEvents' => $PI_PerformanceFailure->number_events,
                'penaltyType' => $PI_PerformanceFailure->penalty_contract,
                'penaltyImposed' => $PI_PerformanceFailure->penalty_imposed,
                'penaltyPaid' => (bool)$PI_PerformanceFailure->penalty_paid
            ];
        } else {
            return array();
        }

    }
}
