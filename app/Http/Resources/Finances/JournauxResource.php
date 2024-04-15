<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournauxResource extends JsonResource
{
    /**
     * @var string|null $start_at
     */
    protected ?string $start_at;

    /**
     * @var string|null $end_at
     */
    protected ?string $end_at;

    public function __construct($resource, string $start_at = null, string $end_at = null)
    {
        parent::__construct($resource);
        $this->start_at = $start_at;
        $this->end_at   = $end_at;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                            => $this->id,
            "fiscal_year"                   => $this->fiscal_year,
            "date_ouverture"                => $this->date_ouverture->format("Y-m-d"),
            "date_fermeture"                => $this->date_fermeture?->format("Y-m-d"),
            "status_exercice"               => $this->status_exercice,
            "journaux"                      => $this->journal_entries->map(function ($entry) {
                return [
                    'id'                    => $entry->journal->id,
                    'code'                  => $entry->journal->code,
                    'name'                  => $entry->journal->name,
                    "ecritures_comptable"   => EcritureComptableResource::collection($entry->journal->ecritures_comptable),
                    'created_at'            => $entry->journal->created_at->format("Y-m-d")
                ];
            }),
            "created_at"                        => $this->created_at->format("Y-m-d")
            // Add more custom attributes or customize existing ones as needed
        ];
    }



    /**
     * Get details of accounts.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $accounts
     * @return array
     */
    protected function ecritures($ecritures_comptable)
    {
        return $ecritures_comptable->map(function ($ecriture_comptable) {
            return [
                'id'                            => $ecriture_comptable->id,
                'libelle'                       => $ecriture_comptable->libelle,
                'total_debit'                   => $ecriture_comptable->lignes_ecriture()->where("type_ecriture_compte", "debit")->sum("montant"),
                'total_debit'                   => $ecriture_comptable->lignes_ecriture()->where("type_ecriture_compte", "credit")->sum("montant"),
                'total_debits'                  => $ecriture_comptable->total_debit,
                'total_credits'                 => $ecriture_comptable->total_credit,
                'date_ecriture'                 => $ecriture_comptable->date_ecriture->format("Y-m-d"),
                'lignes_ecriture'               => $ecriture_comptable->lignes_ecriture,
                'created_at'                    => $ecriture_comptable->created_at->format("Y-m-d")
            ];
        });
    }
}
