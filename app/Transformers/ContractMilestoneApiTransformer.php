<?php

namespace App\Transformers;

use App\Models\Project\ContractMilestones\ContractMilestone;
use App\Models\Project\ContractMilestones\MilestonesCategory;
use Flugg\Responder\Transformers\Transformer;

class ContractMilestoneApiTransformer extends Transformer
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
     * @param  \App\Models\Project\ContractMilestones\ContractMilestone $contractMilestone
     * @return array
     */
    public function transform(ContractMilestone $contractMilestone)
    {
        if($contractMilestone->published){

            $m_category = (new MilestonesCategory())->find($contractMilestone->milestone_category_id);

            return [
                'id' => (int) $contractMilestone->id,
                'title' => $contractMilestone->name,
                'description' => $contractMilestone->description,
                'type' => is_null($m_category) ? null : $m_category->code,
                'status' => $contractMilestone->type->id == 1 ? 'met' : 'scheduled',
                'dueDate' => $contractMilestone->type->id == 1 ? null : (new \DateTime($contractMilestone->date))->format('c'),
                'dateMet' => $contractMilestone->type->id == 1 ? (new \DateTime($contractMilestone->date))->format('c') : null
            ];
        } else {
            return array();
        }
    }
}
