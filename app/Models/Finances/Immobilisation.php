<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Carbon\Carbon;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\MethodeImmobilisationEnum;
use Core\Utils\Enums\TypeImmobilisationEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`Immobilisation`***
 *
 * This model represents the `immobilisations` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class Immobilisation extends ModelContract
{

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = "pgsql";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "immobilisations";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name", "type_immobilisation", "methode_immobilisation", "valeur_origine", "date_acquisition", "date_depreciation", "est_prorata_temporis", "duree_ammortissement", "valeur_residuelle", "accountable_id", "accountable_type", "article_id"
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "est_prorata_temporis"      => TRUE,
        "type_immobilisation"       => TypeImmobilisationEnum::DEFAULT,
        "methode_immobilisation"    => MethodeImmobilisationEnum::DEFAULT
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "date_acquisition", "date_depreciation"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "name", "type_immobilisation", "methode_immobilisation", "valeur_origine", "valeur_residuelle", "date_acquisition", "date_depreciation", "est_prorata_temporis", "duree_ammortissement"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "name"                          => "string",
        "valeur_origine"                => "decimal:2",
        "valeur_residuelle"             => "decimal:2",
        "duree_ammortissement"          => "integer",
        'date_acquisition'              => 'datetime:Y-m-d H:i:s',
        'date_depreciation'             => 'datetime:Y-m-d H:i:s',
        "est_prorata_temporis"          => "boolean",
        "type_immobilisation"           => TypeImmobilisationEnum::class,
        "methode_immobilisation"        => MethodeImmobilisationEnum::class,
        'accountable_id'                => 'string',
        'accountable_type'              => 'string',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        "account_details"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        "ammortissements"
    ];

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
    }

    /**
     * Get the account details.
     *
     * @return mixed
     */
    public function getAccountDetailsAttribute(): mixed
    {
        $account = $this->accountable;
        return [
            "intitule"          => $account->intitule,
            "account_number"    => $account->account_number
        ];
    }

    /**
     * Get the ammortissements
     *
     * @return HasMany
     */
    public function ammortissements(): HasMany
    {
        return $this->hasMany(Ammortissement::class, 'immobilisation_id');
    }

    /**
     * Get the account
     *
     * @return MorphTo
     */
    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeDegressifAvecProrataTemporis(Builder $query)
    {
        $query->where("methode_immobilisation", MethodeImmobilisationEnum::DEGRESSIF->value)->where("est_prorata_temporis", true);
    }

    public function scopeDegressifSansProrataTemporis(Builder $query)
    {
        $query->where("methode_immobilisation", MethodeImmobilisationEnum::DEGRESSIF->value)->where("est_prorata_temporis", false);
    }

    public function scopeLineaireAvecProrataTemporis(Builder $query)
    {
        $query->where("methode_immobilisation", MethodeImmobilisationEnum::LINEAIRE->value)->where("est_prorata_temporis", true);
    }

    public function scopeLineaireSansProrataTemporis(Builder $query)
    {
        $query->where("methode_immobilisation", MethodeImmobilisationEnum::LINEAIRE->value)->where("est_prorata_temporis", false);
    }



    public function createAmmortissements()
    {
        $immobilisation = $this;
        if ($immobilisation) {
            switch ($immobilisation->methode_immobilisation->value) {
                case 'lineaire':
                    $immobilisation->lineaire();
                    break;

                default:
                    $immobilisation->degressif();
                    break;
            }
        }
    }

    public function lineaire()
    {
        $n = $this->duree_ammortissement;
        $taux = 100 / $n;
        //$valeur_origine = $this->valeur_origine;
        //$valeur_residuelle = $this->valeur_residuelle;
        //$base_ammortissable = $valeur_origine - $valeur_residuelle;

        $ammortissements = [];

        $item = [
            "taux" => $taux
        ];

        $base_ammortissable = $this->valeur_origine;

        $item = array_merge($item, [
            "montant" => $base_ammortissable,
            "annete" => $base_ammortissable * ($taux / 100)
        ]);


        if ($this->lineaireAvecProrataTemporis()->count()) {

            $start_date = $this->date_acquisition;

            $index = $actual_month = 0;

            $item = [$index => $item];

            $interval = $this->date_acquisition->diff(\Carbon\Carbon::parse($this->date_acquisition->addYears($n)->format("Y") . "-12-31"));

            $total_month = ($interval->format('%y') * 12) + $interval->format('%m');

            $actual_month = \Carbon\Carbon::parse($start_date)->diff(\Carbon\Carbon::parse($start_date->year . "-12-31"))->format("%m");
            $last_month = 12;
            if ($actual_month < 12) {
                $item[$index]["date_debut"] = \Carbon\Carbon::parse($start_date)->format("Y-m-d");
                $item[$index]["date_fin"]   = \Carbon\Carbon::parse($start_date)->year . "-12-31";
                $last_month = 12 - $last_month;
            } else {
                $item[$index]["date_debut"] = \Carbon\Carbon::parse($start_date)->year . "-01-01";
                $item[$index]["date_fin"]   = \Carbon\Carbon::parse($start_date)->year . "-12-31";
                $actual_month = 12;
            }

            $item[$index]["taux"] = $taux;
            $item[$index]["montant"] = $base_ammortissable;
            $item[$index]["annete"] = $base_ammortissable * ($taux / 100);
            
            $valeur_ammortissable =  $item[$index]["annete"] * ($index + 1);

            $item[$index]["valeur_ammortissable"] = $valeur_ammortissable;
            $item[$index]["valeur_comptable"] = $base_ammortissable - $valeur_ammortissable;

            while ($actual_month < $total_month) {
                $index++;
                $actual_month += 12;

                $item[$index]["date_debut"] = \Carbon\Carbon::parse($start_date)->addYears($index)->year . "-01-01";

                if(($actual_month + $last_month) === $total_month){
                    
                    $item[$index]["date_fin"] = \Carbon\Carbon::parse($start_date)->addYears($index)->addMonths($last_month)->format("Y-m-d");
                }
                else {
                    $item[$index]["date_fin"] = \Carbon\Carbon::parse($start_date)->addYears($index)->year . "-12-31";
                }

                $item[$index]["taux"] = $taux;
                $item[$index]["montant"] = $base_ammortissable;
                $item[$index]["annete"] = $base_ammortissable * ($taux / 100);

                $valeur_ammortissable =  $item[$index]["annete"] * $index;

                $item[$index]["valeur_ammortissable"] = $valeur_ammortissable;
                $item[$index]["valeur_comptable"] = $base_ammortissable - $valeur_ammortissable;              
            }

            collect($item)->each(function($data){
                $this->ammortissements()->create($data);
            });
            
        } else if ($this->lineaireSansProrataTemporis()->count()) {

            for ($i = 0; $i < $n; $i++) {

                $item["montant"] = $base_ammortissable;
                $item["annete"] = $base_ammortissable * ($taux / 100);
                $valeur_ammortissable =  $item["annete"] * ($i + 1);

                $item = array_merge($item, [
                    "valeur_ammortissable" => $valeur_ammortissable,
                    "valeur_comptable" => $base_ammortissable - $valeur_ammortissable,
                    "date_debut" => \Carbon\Carbon::parse($this->date_acquisition)->addYears($i)->year . "-01-01",
                    "date_fin" => \Carbon\Carbon::parse($this->date_acquisition)->addYears($i)->year . "-12-31"
                ]);

                $this->ammortissements()->create($item);

                $ammortissements[] = $item;
            }
        }
    }

    public function degressif()
    {
        if ($this->degressifAvecProrataTemporis()->count()) {
        } else if ($this->degressifSansProrataTemporis()->count()) {
        }
    }
}
