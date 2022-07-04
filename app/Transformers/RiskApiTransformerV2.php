<?php

namespace App\Transformers;

use App\Models\Project\ProjectDetails\PD_Risk;
use App\Models\Project\ProjectDetails\PD_RiskCategory;
use Flugg\Responder\Transformers\Transformer;

class RiskApiTransformerV2 extends Transformer
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
     * @param  \App\Models\Project\ProjectDetails\PD_Risk $PD_Risk
     * @return array
     */
    public function transform(PD_Risk $PD_Risk)
    {
        if($PD_Risk->published){

            // The risk allocation variable of the OCDS PPP extension is a closed enum ...
            switch ($PD_Risk->allocation->name){
                case "Public Sector": $allocation = 'publicAuthority'; break;
                case "Private Sector": $allocation = 'privateParty'; break;
                default: $allocation = null;
            }

            $r_category = (new PD_RiskCategory())->find($PD_Risk->risk_category_id);

            return [
                'id' => (string) $PD_Risk->id,
                'description' => $PD_Risk->description,
                'category' => is_null($r_category) ? null : $r_category->code,
                'allocation' => $allocation,
                'notes' => $PD_Risk->name
            ];

        } else {
            return array();
        }
    }
}
