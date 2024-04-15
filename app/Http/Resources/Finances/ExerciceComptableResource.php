<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciceComptableResource extends JsonResource
{
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
            "date_fermeture"                => $this->date_fermeture,
            "status_exercice"               => $this->status_exercice,
            "plan_comptable"                => $this->whenLoaded('plan_comptable', function () {
                return [
                    "id"                        => $this->plan_comptable->id,
                    "code"                      => $this->plan_comptable->code,
                    "name"                      => $this->plan_comptable->name,
                    "description"               => $this->plan_comptable->description,
                    "est_valider"               => $this->plan_comptable->est_valider,
                    "accounts"                  =>
                    $this->plan_comptable->accounts->map(function ($account) {
                        return [
                            'id'                    => $account->id,
                            'intitule'              => $account->intitule,
                            "classe_de_compte"      => $account->classe_de_compte,
                            "categorie_de_compte"   => $account->categorie_de_compte,
                            'account_number'        => $account->account_number,
                            "solde_debit"           => $account->balance?$account->balance->solde_debit: "0.00",
                            "solde_credit"          => $account->balance?$account->balance->solde_credit: "0.00",
                            "sub_accounts"          => $this->sub_accounts($account->sous_comptes),
                            'created_at'            => $account->created_at->format("Y-m-d")
                        ];
                    }),
                    'created_at'            => $this->plan_comptable->created_at->format("Y-m-d")
                ];
            }),
            "created_at"                    => $this->created_at->format("Y-m-d")
            // Add more custom attributes or customize existing ones as needed
        ];
    }



    /**
     * Get details of accounts.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $accounts
     * @return array
     */
    protected function sub_accounts($accounts)
    {
        return $accounts->map(function ($account) {
            return [
                'id'                    => $account->id,
                'intitule'              => $account->intitule,
                'account_number'        => $account->account_number,
                "solde_debit"           => $account->balance?$account->balance->solde_debit: "0.00",
                "solde_credit"          => $account->balance?$account->balance->solde_credit: "0.00",
                "sub_divisions"         => $this->sub_accounts($account->sub_divisions),
                'created_at'            => $account->created_at->format("Y-m-d")
            ];
        });
    }
}
