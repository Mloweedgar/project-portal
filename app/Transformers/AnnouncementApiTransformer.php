<?php

namespace App\Transformers;

use App\Http\Controllers\UploaderController;
use App\Models\Project\ProjectDetails\PD_Announcement;
use Flugg\Responder\Transformers\Transformer;

class AnnouncementApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Announcement $PD_Announcement
     * @return array
     */
    public function transform(PD_Announcement $PD_Announcement)
    {
        if($PD_Announcement->published){
            return [
                'id' => (int) $PD_Announcement->id,
                'name' => $PD_Announcement->name,
                'description' => $PD_Announcement->description,
                'documents' => UploaderController::documentsApiLoader(
                    $PD_Announcement->projectDetail->project,
                    ["section" => "a", "position" => $PD_Announcement->id]
                ),
                'datePublished' => (new \DateTime($PD_Announcement->date))->format('c'),
            ];
        } else {
            return array();
        }

    }
}
