<?php

namespace App\Transformers;

use App\Models\Entity;
use Flugg\Responder\Transformers\Transformer;

class PartiesApiTransformerV2 extends Transformer
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
        $party_transformed = array();
        $party_transformed['id'] = (string) $party->id;
        $party_transformed['name'] = $party->name;
        $party_transformed['roles'][] = "procuringEntity"; // This is mandatory or the validation will fail
        $party_transformed['identifier'] = array(
            "scheme" => null,
            "id" => (string) $party->id,
            "legalName" => $party->name,
            "uri" => null
        );
        $party_transformed['address'] = array(
            "streetAddress" => $party->address,
            "locality" => null,
            "region" => null,
            "postalCode" => null,
            "countryName" => null
        );
        $party_transformed['contactPoint'] = array(
            "name" => $party->name_representative,
            "email" => $party->email,
            "telephone" => $party->tel,
            "faxNumber" => $party->fax,
            "url" => $party->url
        );
        return $party_transformed;
    }
}
