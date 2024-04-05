<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceDesComptesResource extends JsonResource
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
            "accounts"                      => $this->plan_comptable->accounts->map(function ($account) {
                dump($account->transactions);
                /* dd([
                    "id" => $account->id,
                    "account_number" => $account->account_number,
                    "crediteur" => $account->balance->solde_credit,
                    "debiteur" => $account->balance->solde_debit
                ]); */
                return [
                    'id'                    => $account->id,
                    'intitule'              => $account->intitule,
                    "classe_de_compte"      => $account->classe_de_compte,
                    "categorie_de_compte"   => $account->categorie_de_compte,
                    'account_number'        => $account->account_number,
                    "solde_debiteur"        => $account->balance ? $account->balance->solde_debit : "0.00",
                    "solde_crediteur"       => $account->balance ? $account->balance->solde_credit : "0.00",

                    "mouvement_debit"       => $account->transactions()->where("type_ecriture_compte", "debit")->whereBetween("created_at", [$this->date_ouverture->format("Y-m-d"), $this->fiscal_year . "-" . $this->periode_exercice->date_fin_periode->format('m-d')])->sum("montant"),
                    "mouvement_credit"      => $account->transactions()->where("type_ecriture_compte", "credit")->whereBetween("created_at", [$this->date_ouverture->format("Y-m-d"), $this->fiscal_year . "-" . $this->periode_exercice->date_fin_periode->format('m-d')])->sum("montant"),
                    "sub_accounts"          => $this->sub_accounts($account->sous_comptes),
                    'created_at'            => $account->created_at->format("Y-m-d")
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
                "solde_debiteur"        => $account->balance ? $account->balance->solde_debit : "0.00",
                "solde_crediteur"       => $account->balance ? $account->balance->solde_credit : "0.00",

                "mouvement_debit"       => $account->transactions()->where("type_ecriture_compte", "debit")->whereBetween("created_at", [$this->date_ouverture->format("Y-m-d"), $this->fiscal_year . "-" . $this->periode_exercice->date_fin_periode->format('m-d')])->sum("montant"),
                "mouvement_credit"      => $account->transactions()->where("type_ecriture_compte", "credit")->whereBetween("created_at", [$this->date_ouverture->format("Y-m-d"), $this->fiscal_year . "-" . $this->periode_exercice->date_fin_periode->format('m-d')])->sum("montant"),
                "sub_divisions"         => $this->sub_accounts($account->sub_divisions),
                'created_at'            => $account->created_at->format("Y-m-d")
            ];
        });
    }
}
