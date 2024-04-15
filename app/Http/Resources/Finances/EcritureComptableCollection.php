<?php

namespace App\Http\Resources\Finances;

use App\Http\Resources\API\PaginateResource;
use App\Models\Finances\EcritureComptable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EcritureComptableCollection extends PaginateResource
{
    public function __construct(mixed $resource, string $resourceClass)
    {
        parent::__construct($resource, $resourceClass);
    }
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArrays(Request $request): array
    {
        return [
            'id'                            => $this->id,
            'libelle'                       => $this->libelle,
            'total_debit'                   => $this->lignes_ecriture()->where("type_ecriture_compte", "debit")->sum("montant"),
            'total_credit'                   => $this->lignes_ecriture()->where("type_ecriture_compte", "credit")->sum("montant"),
            'date_ecriture'                 => $this->date_ecriture?->format("Y-m-d"),
            'lignes_ecriture'               => LignesEcritureComptableResource::collection($this->lignes_ecriture),
            'created_at'                    => $this->created_at?->format("Y-m-d")
        ];
    }
}
