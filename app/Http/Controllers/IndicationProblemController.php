<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Problem;
use App\Models\Indication;
use App\Support\DataColumn;
use Illuminate\Http\Request;
use App\Http\Resources\DataTable;
use App\Models\IndicationProblem;

class IndicationProblemController extends Controller
{
    use DataColumn;

    protected $columns = [
        'code' => ['header' => 'Code', 'sortable' => true, 'filterable' => true, 'type' => 'text'],
        'name' => ['header' => 'Name', 'sortable' => true, 'filterable' => true, 'type' => 'text'],
    ];

    protected $dataFilters = [
        'code' => ['value' => null, 'matchMode' => 'contains'],
        'name' => ['value' => null, 'matchMode' => 'contains'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $problem = Problem::with(['indication'])->paginate($request->integer('rows', 10));

        return Inertia::render('Rule/Index', [
            'index' => (new DataTable($problem))->setFilters($this->dataFilters),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Rule/Form', [
            'problems' => Problem::query()->get('code'),
            'indication' => Indication::query()->get('code')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IndicationProblem $indicationProblem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndicationProblem $indicationProblem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndicationProblem $indicationProblem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndicationProblem $indicationProblem)
    {
        //
    }
}
