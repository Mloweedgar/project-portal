<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Renegotiations;
use Flugg\Responder\Transformers\Transformer;

class RenegotiationsApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Renegotiations $pD_Renegotiations
     * @return array
     */
    public function transform(PD_Renegotiations $pD_Renegotiations)
    {
        if($pD_Renegotiations->published){
            return [
                'id' => (int) $pD_Renegotiations->id,
                'name' => $pD_Renegotiations->name,
                'description' => $pD_Renegotiations->description,
                'documents' => UploaderController::documentsApiLoader(
                    $pD_Renegotiations->projectDetail->project,
                    ["section" => "r", "position" => $pD_Renegotiations->id]
                ),
                'datePublished' => (new \DateTime($pD_Renegotiations->updated_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
