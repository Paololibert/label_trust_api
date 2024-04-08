<?php

namespace App\Http\Resources;

use App\Models\Finances\Account;
use App\Models\Finances\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class BalanceDesComptesResource extends JsonResource
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
            "date_fermeture"                => $this->date_fermeture,
            "status_exercice"               => $this->status_exercice,
            "accounts"                      => $this->accounts->map(function ($account) {
                return [
                    'id'                    => $account->id,
                    'intitule'              => $account->intitule,
                    "classe_de_compte"      => $account->classe_de_compte,
                    "categorie_de_compte"   => $account->categorie_de_compte,
                    'account_number'        => $account->account_number,
                    "solde_debiteur"        => $this->solde($account, "debit"),
                    "solde_crediteur"       => $this->solde($account, "credit"),
                    "mouvement_debit"       => $this->mouvements_debit($account),
                    "mouvement_credit"      => $this->mouvements_credit($account),
                    "sub_accounts"          => $this->sub_accounts($account->sous_comptes),
                    'created_at'            => $account->created_at->format("Y-m-d")
                ];
            }),
            "created_at"                    => $this->created_at->format("Y-m-d")
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
                "solde_debiteur"        => $this->solde($account, "debit"),
                "solde_crediteur"       => $this->solde($account, "credit"),
                "mouvement_debit"       => $this->mouvements_debit($account),
                "mouvement_credit"      => $this->mouvements_credit($account),
                'sub_divisions'         => $this->sub_accounts($account->sub_divisions),
                'created_at'            => $account->created_at->format("Y-m-d")
            ];
        });
    }

    private function mouvements(Account|SubAccount $account)
    {
        return $account->transactions()
            ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
            ->whereHas("ligneable.exercice_comptable_journal", function ($ligne_query) {
                $ligne_query->where("exercice_comptable_id", $this->id);
            })->groupBy('type_ecriture_compte')
            ->select("type_ecriture_compte", DB::raw('SUM(montant) as total'))
            ->groupBy('type_ecriture_compte'); // Specify the columns you want to select;
    }

    private function solde(Account|SubAccount $account, string $type = "debit")
    {
        switch ($type) {
            case 'credit':
                return $this->balance_compte($account) + $this->mouvements_credit($account, $type);
                break;

            default:
                return $this->balance_compte($account) + $this->mouvements_debit($account, $type);
                break;
        }
    }

    private function mouvements_debit(Account|SubAccount $account)
    {
        return $this->mouvements($account)->where("type_ecriture_compte", "debit")->first()?->total ?? 0.00;
    }

    private function mouvements_credit(Account|SubAccount $account)
    {
        return $this->mouvements($account)->where("type_ecriture_compte", "credit")->first()?->total ?? 0.00;
    }

    private function balance_compte(Account|SubAccount $account, string $type = "debit")
    {
        if (/* $account->relationLoaded('balance') &&  */$account->balance) {
            $balance = $account->balance()->where("exercice_comptable_id", $this->id)->first();
            switch ($type) {
                case 'credit':
                    return $balance->solde_credit;
                    break;

                default:
                    return $balance->solde_debit;
                    break;
            }
        }
        return 0.00;
    }

    /* "mouvement_debit"       => $account->transactions()->where("ligneable_type", "App\Models\Finances\EcritureComptable")->whereHas("ligneable.exercice_comptable_journal", function ($query) {
                        $query->where("exercice_comptable_id", $this->id);
                    })->select("type_ecriture_compte", DB::raw('SUM(montant) as total'))->groupBy('type_ecriture_compte')->where("type_ecriture_compte", "debit")->first()?->total ?? 0.00,
                    "mouvement_credit"      => $account->transactions()->where("ligneable_type", "App\Models\Finances\EcritureComptable")->whereHas("ligneable.exercice_comptable_journal", function ($query) {
                        $query->where("exercice_comptable_id", $this->id);
                    })->select("type_ecriture_compte", DB::raw('SUM(montant) as total'))->groupBy('type_ecriture_compte')->where("type_ecriture_compte", "credit")->first()?->total ?? 0.00, */
}
