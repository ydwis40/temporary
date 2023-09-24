<?php

namespace App\Support\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Support\Filterables\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait HasDataTableFilter
{
    public function scopeFilter(Builder $query, Request $request): void
    {
        if ($request->has('filters')) {
            $filters = $request->collect('filters')->mapInto(Filter::class)->filter(function (Filter $filter) {
                return $filter->value !== null;
            });

            $query->where(function (Builder $query) use ($filters) {
                foreach ($filters as $column => $filter) {
                    if ($filter->value) {
                        switch ($filter->matchMode) {

                            case 'equals':
                                $query->where($column, '=', $filter->value, $filter->operator);
                                break;
                            case 'notEquals':
                                $query->where($column, '!=', $filter->value, $filter->operator);
                                break;

                            // Text
                            case 'contains':
                                $query->where($column, 'like', '%' . $filter->value . '%', $filter->operator);
                                break;
                            case 'startsWith':
                                $query->where($column, 'like', $filter->value . '%', $filter->operator);
                                break;
                            case 'endsWith':
                                $query->where($column, 'like', '%' . $filter->value, $filter->operator);
                                break;
                            case 'notContains':
                                $query->where($column, 'not like', '%' . $filter->value . '%', $filter->operator);
                                break;

                            // Numeric
                            case 'lessThan':
                                $query->where($column, '<', $filter->value, $filter->operator);
                                break;
                            case 'lessThanOrEqualTo':
                                $query->where($column, '<=', $filter->value, $filter->operator);
                                break;
                            case 'greaterThan':
                                $query->where($column, '>', $filter->value, $filter->operator);
                                break;
                            case 'greaterThanOrEqualTo':
                                $query->where($column, '>=', $filter->value, $filter->operator);
                                break;

                            // Date
                            // 'dateIs' | 'dateIsNot' | 'dateBefore' | 'dateAfter'
                            case 'dateIs':
                                $date = Carbon::parse($filter->value);
                                $query->whereBetween($column, [$date->clone()->startOfDay(), $date->clone()->endOfDay()], $filter->operator);
                                break;
                            case 'dateIsNot':
                                $date = Carbon::parse($filter->value);
                                $query->whereNotBetween($column, [$date->clone()->startOfDay(), $date->clone()->endOfDay()], $filter->operator);
                                break;
                            case 'dateBefore':
                                $date = Carbon::parse($filter->value);
                                $query->where($column, '<', $date->startOfDay(), $filter->operator);
                                break;
                            case 'dateAfter':
                                $date = Carbon::parse($filter->value);
                                $query->where($column, '>', $date->endOfDay(), $filter->operator);
                                break;
                            default:
                                // DO NOTHING;
                        }
                    }
                }
            });
        }
    }

    public function scopeSort(Builder $query, Request $request): void
    {
        if ($request->filled('sortField')) {
            $query->orderBy($request->get('sortField'), $request->integer('sortOrder') === 1 ? 'asc' : 'desc');
        }

        if ($request->filled('multiSortMeta')) {
            $request->collect('multiSortMeta')->each(function ($item) use ($query) {
                $query->orderBy($item['field'], (int) $item['order'] === 1 ? 'asc' : 'desc');
            });
        }
    }

    /**
     * @param \Illuminate\Contracts\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Collection<array-keys, \App\Support\Filterables\Filter> $filters
     * @param string $column
     * @return void
     */
    protected function runFilter(Builder $query, $filters, $column)
    {
        foreach ($filters as $column => $filter) {
            if ($filter->value) {
                switch ($filter->matchMode) {
                    case 'equals':
                        $query->where($column, '=', $filter->value, $filter->operator);
                        break;
                    case 'contains':
                        $query->where($column, 'like', '%' . $filter->value . '%', $filter->operator);
                        break;
                    case 'dateIs':
                        $date = Carbon::parse($filter->value);
                        $query->whereBetween($column, [$date->clone()->startOfDay(), $date->clone()->endOfDay()], $filter->operator);
                        break;
                    default:
                        // DO NOTHING;
                }
            }
        }
    }

    protected function filterEquals(Builder $query, string $column, array $filter)
    {
        $query->where($column, '=', $filter['value']);
    }
}
