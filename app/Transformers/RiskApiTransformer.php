<?php

namespace App\Transformers;

use App\Models\Project\ProjectDetails\PD_Risk;
use Flugg\Responder\Transformers\Transformer;

class RiskApiTransformer extends Transformer
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
            return [
                'id' => (int) $PD_Risk->id,
                'name' => $PD_Risk->name,
                'description' => $PD_Risk->description,
                'mitigation' => $PD_Risk->mitigation,
                'allocation' => $PD_Risk->allocation->name
            ];
        } else {
            return array();
        }
    }
}
