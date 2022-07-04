<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Financial;
use Flugg\Responder\Transformers\Transformer;

class FinancialStructureApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Financial $PD_Financial
     * @return array
     */
    public function transform(PD_Financial $PD_Financial)
    {
        if($PD_Financial->published){
            return [
                'id' => (int) $PD_Financial->id,
                'name' => $PD_Financial->name,
                'description' => $PD_Financial->description,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_Financial->projectDetail->project,
                    ["section" => "fi", "position" => $PD_Financial->id]
                ),
                'datePublished' => (new \DateTime($PD_Financial->updated_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
