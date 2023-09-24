<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataTable extends ResourceCollection
{
    protected $preserveAllQueryParameters = true;

    protected $filters;

    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Set appended collection
     *
     * @param array $appends
     * @return $this
     */
    public function setAppends($appends)
    {
        $this->collection->each(function ($item) use ($appends) {
            $item->setAppends($appends);
        });
        return $this;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'filters' => $request->get('filters', $this->filters),
            'multiSortMeta' => $request->get('multiSortMeta')
        ];
    }
}
