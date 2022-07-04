<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_GovernmentSupport;
use Flugg\Responder\Transformers\Transformer;

class GovernmentSupportApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_GovernmentSupport $PD_GovernmentSupport
     * @return array
     */
    public function transform(PD_GovernmentSupport $PD_GovernmentSupport)
    {
        if($PD_GovernmentSupport->published){
            return [
                'id' => (int) $PD_GovernmentSupport->id,
                'name' => $PD_GovernmentSupport->name,
                'description' => $PD_GovernmentSupport->description,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_GovernmentSupport->projectDetail->project,
                    ["section" => "gs", "position" => $PD_GovernmentSupport->id]
                ),
                'datePublished' => (new \DateTime($PD_GovernmentSupport->updated_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
