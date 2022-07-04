<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectInformation;
use Flugg\Responder\Transformers\Transformer;

class ProjectInformationApiTransformer extends Transformer
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

            if (isNigeriaICRC() || isGhana() || isNigeriaSovereign()) {

                // Elements Visibility Check
                if($projectInformation->project_need_private) {

                    $out["projectNeed"] = array(
                        "description" => $projectInformation->project_need,
                        'documents' => UploaderController::documentsApiLoader(
                            $projectInformation->project,
                            ["section" => "i", "position" => 2]
                        ),
                    );

                }
                if($projectInformation->description_asset_private) {

                    $out["descriptionOfAsset"] = array(
                        "description" => $projectInformation->description_asset,
                        'documents' => UploaderController::documentsApiLoader(
                            $projectInformation->project,
                            ["section" => "i", "position" => 3]
                        ),
                    );

                }
                if($projectInformation->description_services_private) {

                    $out["descriptionOfServices"] = array(
                        "description" => $projectInformation->description_services,
                        'documents' => UploaderController::documentsApiLoader(
                            $projectInformation->project,
                            ["section" => "i", "position" => 4]
                        ),
                    );

                }
                if($projectInformation->reasons_ppp_private) {

                    $out["rationalePPP"] = array(
                        "description" => $projectInformation->reasons_ppp,
                        'documents' => UploaderController::documentsApiLoader(
                            $projectInformation->project,
                            ["section" => "i", "position" => 5]
                        ),
                    );

                }
                if($projectInformation->stakeholder_consultation_private) {

                    $out["stakeholderConsultations"] = array(
                        "description" => $projectInformation->stakeholder_consultation,
                        'documents' => UploaderController::documentsApiLoader(
                            $projectInformation->project,
                            ["section" => "i", "position" => 6]
                        ),
                    );

                }
            }
        }

        // Return Output
        return $out;
    }
}
