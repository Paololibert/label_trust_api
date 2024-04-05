<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\DataTransfertObjects;

use App\Models\Finances\ExerciceComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`PeriodeOfBalanceDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`ExerciceComptable`*** model.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\DataTransfertObjects`***
 */
class PeriodeOfBalanceDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return ExerciceComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $exercice = ExerciceComptable::find(request()->route("exercice_comptable_id"));
        $periode = $exercice?->periode_exercice;
        $rules = array_merge([
            "from_date"                                                          => ["sometimes", "date_format:d/m/Y", "after_or_equal:". $periode->date_debut_periode . "/{$exercice->fiscal_year}", 'before_or_equal:' . $periode->date_fin_periode . "/{$exercice->fiscal_year}"],
            "to_date"                                                            => ["required", "date_format:d/m/Y", "after_or_equal:from_date"],
        ], $rules);

        return $this->rules = parent::rules($rules);
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        $default_messages = array_merge([
            "from_date.after_or_equal"  => "The from date must be after or equal to the start of the exercise period.",
            "from_date.before_or_equal" => "The from date must be before or equal to the end of the exercise period.",
            "to_date.required"          => "The to date is required.",
            "to_date.date"              => "The to date must be a valid date.",
            "to_date.date_format"       => "The to date must be in the format d/m/Y.",
            "to_date.after_or_equal"    => "The to date must be after or equal to the from date.",
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
