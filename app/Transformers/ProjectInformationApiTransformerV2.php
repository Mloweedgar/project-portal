<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectInformation;
use Flugg\Responder\Transformers\Transformer;

class ProjectInformationApiTransformerV2 extends Transformer
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
     * @param  \App\Models\Project\ProjectInformation $projectInformation
     * @return array
     */
    public function transform(ProjectInformation $projectInformation)
    {
        // Output
        $out = array();

        // Global Visibility Check
        if($projectInformation->project->isProjectInformationActive()){

        }

        // Return Output
        return $out;
    }
}
