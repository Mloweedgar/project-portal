<?php

namespace App\Transformers;

use App\Models\Entity;
use Flugg\Responder\Transformers\Transformer;

class PartiesApiTransformer extends Transformer
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
     * @param Entity $party
     * @return array
     * @internal param Entity $entity
     */
    public function transform(Entity $party)
    {
        return array(
            "id" => $party->id,
            "name" => $party->name,
            "nameRepresentative" => $party->name_representative,
            "address" => $party->address,
            "phone" => $party->tel,
            "fax" => $party->fax,
            "email" => $party->email,
            "description" => $party->description,
            "facebook" => $party->facebook,
            "twitter" => $party->twitter,
            "instagram" => $party->instagram,
            "website" => $party->url
        );
    }
}
