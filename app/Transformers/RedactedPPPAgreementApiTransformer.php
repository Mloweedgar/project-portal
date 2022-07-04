<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Document;
use Flugg\Responder\Transformers\Transformer;

class RedactedPPPAgreementApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Document $pD_Document
     * @return array
     */
    public function transform(PD_Document $pD_Document)
    {
        if($pD_Document->published){
            return array(
                "id" => $pD_Document->id,
                "name" => $pD_Document->name,
                "description" => $pD_Document->description,
                "documents" => UploaderController::documentsApiLoader(
                    $pD_Document->projectDetail->project,
                    ["section" => "d", "position" => $pD_Document->id]
                ),
                'datePublished' => (new \DateTime($pD_Document->updated_at))->format('c'),
            );
        } else {
            return array();
        }
    }
}
