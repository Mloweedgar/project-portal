<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\PerformanceInformation\PI_PerformanceAssessment;
use Flugg\Responder\Transformers\Transformer;

class PerformanceAssessmentsApiTransformer extends Transformer
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
     * @param  \App\Models\Project\PerformanceInformation\PI_PerformanceAssessment $pI_PerformanceAssessment
     * @return array
     */
    public function transform(PI_PerformanceAssessment $pI_PerformanceAssessment)
    {
        if($pI_PerformanceAssessment->published){
            return [
                'id' => (int) $pI_PerformanceAssessment->id,
                'name' => $pI_PerformanceAssessment->name,
                'description' => $pI_PerformanceAssessment->description,
                'documents' => UploaderController::documentsApiLoader(
                    $pI_PerformanceAssessment->performance_information->project,
                    array("section" => "pa", "position" => $pI_PerformanceAssessment->id)
                ),
                'datePublished' => (new \DateTime($pI_PerformanceAssessment->updated_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
