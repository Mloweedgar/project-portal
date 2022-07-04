<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Procurement;
use Flugg\Responder\Transformers\Transformer;

class ProcurementDocumentApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Procurement $PD_Procurement
     * @return array
     */
    public function transform(PD_Procurement $PD_Procurement)
    {
        if($PD_Procurement->published){
            return [
                'id' => (int) $PD_Procurement->id,
                'name' => $PD_Procurement->name,
                'description' => $PD_Procurement->description,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_Procurement->project,
                    ["section" => "pri", "position" => $PD_Procurement->id]
                ),
                'datePublished' => (new \DateTime($PD_Procurement->created_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
