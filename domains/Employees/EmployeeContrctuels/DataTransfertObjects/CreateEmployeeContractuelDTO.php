<?php

declare(strict_types=1);

namespace Domains\Employees\DataTransfertObjects;

use Domains\Users\DataTransfertObjects\CreateUserDTO;
use App\Models\EmployeeContractuel;
use Core\Utils\DataTransfertObjects\BaseDTO;

class CreateEmployeeContractuelDTO extends BaseDTO
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
        return EmployeeContractuel::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $userDTO = new CreateUserDTO();
        $userRules = $userDTO->rules();

        $rules = array_merge([
            'matricule'             => ['required', 'string'],
            'type_employee'         => ['required', 'string'],
            'statut_employee'       => ['required', 'string'],
            'reference'             => ['required', 'string'],
            'type_contract'         => ['required', 'string'],
            'duree'                 => ['required', 'decimal'],
            'date_debut'            => ['required', 'date'],
            'date_fin'              => ['required', 'date'],
            'contract_status'       => ['required', 'string'],
            'renouvelable'          => ['required', 'boolean'],
            'est_renouveler'        => ['required', 'boolean'],
            'poste_id'              => ['required', 'string', 'exists:postes,id'],
            'unite_mesures_id'      => ['required', 'string', 'exists:unite_mesures,id'],
            'can_be_deleted'        => ['sometimes', 'boolean']
            
        ], $userRules);

        return $this->rules = parent::rules($rules);
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        // Vous pouvez soit copier les messages de validation de CreateUserDTO ici
        // ou bien utiliser les messages de validation de CreateUserDTO directement

        $userDTO = new CreateUserDTO();
        $userMessages = $userDTO->messages();

        return $this->messages = parent::messages($userMessages);
    }
}
