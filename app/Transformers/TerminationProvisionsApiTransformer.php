<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_ContractTermination;
use Flugg\Responder\Transformers\Transformer;

class TerminationProvisionsApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_ContractTermination $PD_ContractTermination
     * @return array
     */
    public function transform(PD_ContractTermination $PD_ContractTermination)
    {
        if($PD_ContractTermination->published){
            return [
                'id' => (int) $PD_ContractTermination->id,
                'partyType' => $PD_ContractTermination->party_type,
                'name' => $PD_ContractTermination->name,
                'description' => $PD_ContractTermination->description,
                'payment' => $PD_ContractTermination->termination_payment,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_ContractTermination->projectDetail->project,
                    ["section" => "ct", "position" => $PD_ContractTermination->id]
                ),
            ];
        } else {
            return array();
        }
    }
}
