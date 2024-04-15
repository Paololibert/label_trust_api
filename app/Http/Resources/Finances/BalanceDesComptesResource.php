<?php

namespace App\Http\Resources\Finances;

use App\Models\Finances\Account;
use App\Models\Finances\SubAccount;
use Carbon\Carbon;
use Core\Utils\Enums\StatusExerciceEnum;
use Core\Utils\Exceptions\ApplicationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

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
        $this->start_at = $start_at ? \Carbon\Carbon::createFromFormat("d/m/Y", $start_at)->format("Y-m-d") : \Carbon\Carbon::parse($this->date_ouverture)->format("Y-m-d");
        $this->end_at   = $end_at ? \Carbon\Carbon::createFromFormat("d/m/Y", $end_at)->format("Y-m-d") : ($this->status_exercice === StatusExerciceEnum::CLOSE ? $this->date_fermeture : ($this->fiscal_year . "-" . $this->periode_exercice->date_fin_periode->format('m-d')));
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $comptes = $this->plan_comptable->accounts()
            ->ordoring()
            ->get()->sortBy(function ($query) {
                return $query->classe->class_number;
            })->groupBy('classe.intitule');
        return [
            "id"                            => $this->id,
            "fiscal_year"                   => $this->fiscal_year,
            "date_ouverture"                => $this->date_ouverture->format("Y-m-d"),
            "date_fermeture"                => $this->date_fermeture,
            "status_exercice"               => $this->status_exercice,
            "plan_comptable"                => [
                'id'                        => $this->plan_comptable->id,
                'code'                      => $this->plan_comptable->code,
                'name'                      => $this->plan_comptable->name,
                "comptes"                   => $comptes->map(function ($accounts) {
                    return [
                        "accounts" => $accounts->map(function ($account) {
                            return [
                                'id'                    => $account->id,
                                'intitule'              => $account->intitule,
                                "categorie_de_compte"   => $account->categorie_de_compte,
                                'account_number'        => $account->account_number,
                                "solde_debiteur"        => $account->balanceDeCompte(type: "debiteur", exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                                "solde_crediteur"       => $account->balanceDeCompte(type: "crediteur", exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at), //$this->balance_compte($account, "crediteur"),
                                "mouvement_debit"       => $account->mouvementDebit(exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                                "mouvement_credit"      => $account->mouvementCredit(exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                                "sub_accounts"          => $this->sub_accounts($account->sous_comptes()->ordoring()->get()),
                                'created_at'            => $account->created_at->format("Y-m-d")
                            ];
                        })
                    ];
                }),
            ],
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
                "solde_debiteur"        => $account->balanceDeCompte(type: "debiteur", exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                "solde_crediteur"       => $account->balanceDeCompte(type: "crediteur", exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at), //$this->balance_compte($account, "crediteur"),
                "mouvement_debit"       => $account->mouvementDebit(exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                "mouvement_credit"      => $account->mouvementCredit(exercice_comptable_id: $this->id, start_at: $this->start_at, end_at: $this->end_at),
                'sub_divisions'         => $this->sub_accounts($account->sub_divisions()->ordoring()->get()),
                'created_at'            => $account->created_at->format("Y-m-d")
            ];
        });
    }
}
