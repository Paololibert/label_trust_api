<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanComptableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->accounts->sortByRelatedAttribute("classe", "class_number")->groupBy(function ($account) {
            return   "Classe " . $account->classe->class_number . " - " . $account->classe->intitule;
        });

        $index = 0;

        // Use the map function to transform the collection
        /* $data->mapWithKeys(function ($accounts, $key) use(&$formattedData, &$index) {
            // Extract the class details
            $classIntitule = $key;
            $classAccounts = AccountCollection::collection($accounts);

            // Return the class details in the desired format
            $formattedData[$index] = [
                'class_intitule' => $classIntitule,
                'class_accounts' => $classAccounts,
            ];
            $index ++;
        }); */

        // Now $formattedData contains the desired formatted structure

        

        return [
            "id"                        => $this->id,
            "code"                      => $this->code,
            "name"                      => $this->name,
            "description"               => $this->description,
            "est_valider"               => $this->est_valider,
            $this->mergeWhen($this->relationLoaded("accounts"), function () use ($data, $index) {
                $accounts = [];
                foreach ($data as $key => $items) {
                    $accounts[$index] =  [
                        "intitule" => $key,
                        "accounts" => AccountCollection::collection($items)
                    ];
        
                    $index++;
                }
                
                return ["comptes"     => $accounts];
                
                /* return [
                    "comptes"     => $data->mapWithKeys(function ($classe, $key) use ($index) {
                        return ["intitule" => $key, "accounts" => AccountCollection::collection($classe)];
                    })
                ]; */
                /* $data->map(function ($classe, $key) {
                        return [
                            $key => [
                                "ok" => AccountCollection::collection($classe)
                            ]
                        ];
                        //return AccountCollection::collection($classe);
                    }) */
            })
        ];
    }
}
