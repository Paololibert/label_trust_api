<?php

declare(strict_types=1);

namespace App\Imports;

use Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadWriteRepository;
use Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadWriteRepository;
use Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class AccountsImport implements ToArray
{
    /**
     * @param array $rows
     *
     * @return array
     */
    public function array(array $rows): array
    {
        $groupedAccounts = [];
        $currentClasse = null;

        $index = $classe_key = 0;

        foreach ($rows as $row) {
            if (!is_null($row[0]) && strpos($row[0], 'CLASSE') !== false) {

                $class_number = (int) substr((string) strtolower((string) $row[0]), strlen(strtolower("CLASSE "))); //$this->extractIntegerFromString($row[0]);

                // If not, it's a classe row
                $currentClasse = [
                    'class_number' => $row[0],
                    'intitule' => $row[1]
                ];

                $classe = app(ClasseDeCompteReadWriteRepository::class)->getModel()->firstOrCreate(['class_number' => $class_number], array_merge($currentClasse, ["class_number" => $class_number]));

                $currentClasse["classe_id"] = $classe->id;

                $classe_key = ++$index;
            } else if ((is_numeric($row[0]) || is_string($row[0])) && !is_null($row[0])) { // Check if the first column contains an account number

                if (!isset($row[1]) || !isset($row[2]) || !isset($row[3])) {
                    break;
                } else if (is_null($row[1]) || is_null($row[2]) || is_null($row[3])) {
                    break;
                }

                // It's an account row
                $accountNumber = $row[0];
                $formattedAccount = [
                    'account_number' => $accountNumber,
                    'compte_data' => [
                        'type_de_compte'            => $row[3],
                        'name'                      => $row[1],
                        'categorie_de_compte_id'    => app(CategorieDeCompteReadWriteRepository::class)->getModel()->firstOrCreate(['name' => strtolower($row[2])], ['name' => $row[2]])->id
                    ]
                ];


                // Check if the account has a parent
                if (strlen($accountNumber) > 2) {
                    $parentAccountNumber = substr($accountNumber, 0, -1);
                    $parentClassNumber = substr($parentAccountNumber, 0, 1);

                    // Check if it's a sub-division
                    if (strlen($accountNumber) >= 4) {
                        // Find the parent of the sub-division
                        $this->findParent(groupedAccounts: $groupedAccounts[$classe_key], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedAccount, maxDepth: strlen($parentAccountNumber) - 2);
                    } else {
                        // It's a sub-account
                        $groupedAccounts[$classe_key]['accounts'][$parentAccountNumber]['sub_accounts'][$accountNumber] = $formattedAccount;
                    }
                } else {
                    // It's a parent account

                    $formattedAccount = array_merge($formattedAccount, ["classe_id" => $currentClasse['classe_id']]);

                    // Add the account to the current classe
                    $groupedAccounts[$classe_key]['classe_intitule']                        = $currentClasse['intitule'];
                    $groupedAccounts[$classe_key]['class_number']                           = $currentClasse['class_number'];
                    $groupedAccounts[$classe_key]['accounts'][$accountNumber]               = array_merge($formattedAccount, ["classe_id" => $currentClasse['classe_id']]);

                    $groupedAccounts[$classe_key]['accounts'][$accountNumber]['classe_id']  = $currentClasse['classe_id'];
                    //$groupedAccounts[$currentClasse['class_number']]['accounts'][$accountNumber] = $formattedAccount;
                }
            }
        }

        $plan["accounts"] = collect($groupedAccounts)->pluck("accounts")->collapse()->toArray();

        /*
            //$dto = new CreatePlanComptableDTO(data: $plan);

            request()->request->add($plan);

            $createRequest = app(ResourceRequest::class, ["request" => request(), "dto" => new CreatePlanComptableDTO/* , "data" => $plan, "rules" => $dto->rules() *//*]);
            $createRequest = new ResourceRequest(request: request(), dto: new CreatePlanComptableDTO(data: $plan, rules:$dto->rules()));

            // Validate the incoming request using the ResourceRequest rules
            if ($createRequest) {
                $createRequest->validate($createRequest->rules());
            }
        */

        return $plan;
    }

    // Function to recursively find the parent of a sub-division
    private function findParent(&$groupedAccounts, int $parentClassNumber, string|int $parentAccountNumber, $accountNumber, array $formattedSubDivision, int $maxDepth = 5)
    {
        // Check if the max depth has been reached
        if ($maxDepth < 0) {
            return;
        }

        if (isset($groupedAccounts["accounts"])) {

            $parent = substr($parentAccountNumber, 0, 2);

            while (strlen($parent) > 2) {
                $parent = substr($parent, 0, -1);
            }

            $this->findParent(groupedAccounts: $groupedAccounts["accounts"][$parent]["sub_accounts"], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedSubDivision, maxDepth: $maxDepth - 1);
        } else {

            if (isset($groupedAccounts[$parentAccountNumber]) && $maxDepth === 0) {

                // Add the sub-division to the parent sub-account's sub_divisions array
                $groupedAccounts[$parentAccountNumber]['sub_divisions'][$accountNumber] = $formattedSubDivision;
            } else {
                $parent = substr($parentAccountNumber, 0, -1);

                while (!(strlen($parent) - 2 === $maxDepth)) {
                    $parent = substr($parent, 0, -1);
                }

                $this->findParent(groupedAccounts: $groupedAccounts[$parent]['sub_divisions'], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedSubDivision, maxDepth: $maxDepth - 1);
            }
        }
    }
}
