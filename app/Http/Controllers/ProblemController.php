<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Problem;
use App\Support\DataColumn;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\DataTable;

class ProblemController extends Controller
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
        $problem = Problem::query()->filter($request);

        return Inertia::render('Problem/Index', [
            'index' => (new DataTable($problem->paginate($request->integer('rows', 10))))->setFilters($this->dataFilters),
            'columns' => $this->generateColumn(),
            'filters' => $request->get('filters', $this->dataFilters)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Problem/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Problem::create([
            'code' => $this->generateProblemCode(),
            'name' => $request->name,
            'solution' => $request->solution
        ]);

        return redirect('problem');
    }

    protected function generateProblemCode()
    {
        return 'A' . Str::padLeft((intval(str(Problem::query()->latest()->first()?->code)->replace('A', '')) + 1), 2, '0');
    }

    /**
     * Display the specified resource.
     */
    public function show(Problem $problem)
    {
        return Inertia::render('Problem/Show', [
            'problem' => $problem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Problem $problem)
    {
        return Inertia::render('Problem/Form', [
            'problem' => $problem
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Problem $problem)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $problem->update([
            'name' => $request->name,
            'solution' => $request->solution
        ]);

        return redirect('problem');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        $problem->delete();

        return redirect('problem');
    }
}
