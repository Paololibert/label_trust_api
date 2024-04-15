<?php

namespace App\Http\Resources\Finances;

use App\Models\Finances\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $key = $this->resource::class === Account::class ? "sous_comptes" : "sub_divisions";

        return [
            'id'                    => $this->id,
            'intitule'              => $this->intitule,
            "categorie_de_compte"   => $this->categorie_de_compte,
            $this->mergeWhen($this->relationLoaded("classe"), ["class_number" => $this->classe?->class_number]),
            'account_number'        => $this->account_number,
            
            // Conditionally include sub-accounts when the relation is loaded
            $this->mergeWhen($this->relationLoaded($key) && $this->$key->isNotEmpty(), [
                $key => AccountCollection::collection($this->$key)
            ])
        ];
    }
}
