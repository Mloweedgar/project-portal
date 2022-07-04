<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Procurement;
use Flugg\Responder\Transformers\Transformer;

class ProcurementDocumentApiTransformerV2 extends Transformer
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
            return UploaderController::documentsApiLoader(
                    $PD_Procurement->project,
                    ["section" => "pri", "position" => $PD_Procurement->id]
                );
        } else {
            return array();
        }
    }
}
