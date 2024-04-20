<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LignesEcritureComptableCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                            => $this->id,
            'account_number'                => $this->accountable?->account_number,
            'account_intitule'              => $this->accountable?->intitule,
            'type_ecriture_compte'          => $this->type_ecriture_compte->value,
            'montant'                       => $this->montant
        ];
    }
}
