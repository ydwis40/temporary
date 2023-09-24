<?php

namespace App\Support\Filterables;

class Filter
{
    /**
     * @var string|null
     */
    public $value;

    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $matchMode;

    public $operator = 'and';

    public $constraints;

    public function __construct(array $value = null, string $column = null)
    {
        $this->column = $column;

        if (isset($value['operator'])) {
            $this->operator = $value['operator'];
            $this->constraints = collect($value['constraints'])->chunk(2)
            ->mapSpread(fn ($value, $matchMode) => array_merge($value, $matchMode))->mapInto(Filter::class)->filter(function (Filter $filter) {
                return $filter->value !== null;
            });
        } else {
            $this->value = $value['value'];
            $this->matchMode = $value['matchMode'];
        }
    }
}
