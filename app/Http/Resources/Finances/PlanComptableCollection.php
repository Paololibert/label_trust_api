<?php

namespace App\Http\Resources\Finances;

use App\Http\Resources\API\PaginateResource;
use Illuminate\Http\Request;

class PlanComptableCollection  extends PaginateResource
{
    public function __construct(mixed $resource, string $resourceClass)
    {
        parent::__construct($resource, $resourceClass);
    }
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                        => $this->id,
            "code"                      => $this->code,
            "name"                      => $this->name,
            "description"               => $this->description,
            "est_valider"               => $this->est_valider,
            "created_at"                => $this->created_at->format("Y-m-d")
        ];
    }
}
