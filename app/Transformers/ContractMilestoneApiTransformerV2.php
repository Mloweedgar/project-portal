<?php

namespace App\Transformers;

use App\Models\Project\ContractMilestones\ContractMilestone;
use Flugg\Responder\Transformers\Transformer;

class ContractMilestoneApiTransformerV2 extends Transformer
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
     * @param $stage
     * @return array
     */
    public function transform(ContractMilestone $contractMilestone, $stage)
    {
        if($contractMilestone->published && $this->isInStage($contractMilestone->name, $stage)){
            return [
                'id' => (int) $contractMilestone->id,
                'title' => $contractMilestone->name,
                'description' => $contractMilestone->description,
                'status' => $contractMilestone->type->id == 1 ? 'met' : 'scheduled',
                'dueDate' => $contractMilestone->type->id == 1 ? null : (new \DateTime($contractMilestone->date))->format('c'),
                'dateMet' => $contractMilestone->type->id == 1 ? (new \DateTime($contractMilestone->date))->format('c') : null
            ];
        } else {
            return array();
        }
    }

    /**
     * @param $milestoneTitle
     * @param $stage
     * @return bool
     */
    public function isInStage($milestoneTitle, $stage){

        switch ($milestoneTitle){

            case "Project proposal received":
            case "Project proposal screened":
            case "Project proposal enters list of published projects pipeline":
            case "Transaction Advisors appointed":
            case "Project feasibility study approved":
            case "OBC compliance certificate issued":
            case "FEC approval for OBC":
            case "FBC compliance certificate issued":
            case "Enters national priority list":
            case "Feasibility study starts":
            case "FEC approval for FBC": $is_in_stage = ($stage == "Planning") ? true : false; break;
            case "Commercial close":
            case "Financial close":
            case "Beginning of construction or development":
            case "Completion of construction or development":
            case "Commissioning of project":
            case "Expiry of contract":
            case "Construction started":
            case "Construction completed": $is_in_stage = ($stage == "Implementation") ? true : false; break;
            case "EOI":
            case "RFQ":
            case "RFP":
            case "Selection of preferred bidder":
            case "Award": $is_in_stage = ($stage == "Procurement") ? true : false; break;

            default: $is_in_stage = false;

        }

        return $is_in_stage;

    }
}
