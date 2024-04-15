<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * @var string
     */
    protected string $resourceClass;

    /**
     * Constuctor
     * 
     * @param mixed $resource
     * @param string $resourceClasse
     * 
     * @return void
     */
    public function __construct($resource, string $resourceClass)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
    }

    public function collect($resource)
    {
        return $this->resourceClass::collection($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->collect($this->items()),
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'path' => $this->path(),
            'per_page' => $this->perPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total()
        ];
    }
}
