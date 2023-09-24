<?php

namespace App\Support;

use InvalidArgumentException;

trait DataColumn
{
    protected $dataColumn;

    protected function generateColumn()
    {
        $dataColumn = collect();

        $columnsCollection = collect($this->columns);

        $columnsCollection->each(function ($item, $key) use ($dataColumn) {
            if (is_int($key)) {
                throw new InvalidArgumentException("Key must string for column", 1);
            }

            $column = [
                'field' => $key,
                'header' => $item['header'],
                'sortable' => $item['sortable'] ?? false,
                'filterable' => $item['filterable'] ?? false,
                'type' => $item['type'] ?? 'string'
            ];

            $dataColumn->push($column);
        });

        return $dataColumn;
    }
}
