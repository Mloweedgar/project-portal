<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Tariffs;
use Flugg\Responder\Transformers\Transformer;

class TariffsApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Tariffs $PD_Tariffs
     * @return array
     */
    public function transform(PD_Tariffs $PD_Tariffs)
    {
        if($PD_Tariffs->published){
            return [
                'id' => (int) $PD_Tariffs->id,
                'name' => $PD_Tariffs->name,
                'description' => $PD_Tariffs->description,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_Tariffs->projectDetail->project,
                    ["section" => "t", "position" => $PD_Tariffs->id]
                ),
                'datePublished' => (new \DateTime($PD_Tariffs->updated_at))->format('c'),
            ];
        } else {
            return array();
        }
    }
}
