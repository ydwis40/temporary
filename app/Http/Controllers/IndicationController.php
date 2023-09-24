<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Indication;
use App\Support\DataColumn;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\DataTable;
use Illuminate\Http\RedirectResponse;

class IndicationController extends Controller
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
        $indication = Indication::query()->filter($request);

        return Inertia::render('Indication/Index', [
            'index' => (new DataTable($indication->paginate($request->integer('rows', 10))))->setFilters($this->dataFilters),
            'columns' => $this->generateColumn(),
            'filters' => $request->get('filters', $this->dataFilters)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Indication/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);

        Indication::create([
            'code' => $this->generateIndicationCode(),
            'name' => $request->name
        ]);

        return redirect('indication');
    }

    public function generateIndicationCode()
    {
        return 'B' . Str::padLeft((intval(Indication::query()->latest()->first()?->code) + 1), 2, '0');
    }

    /**
     * Display the specified resource.
     */
    public function show(Indication $indication)
    {
        return Inertia::render('Indication/Show', [
            'indication' => $indication
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Indication $indication)
    {
        return Inertia::render('Indication/Form', $indication->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Indication $indication)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $indication->update([
            'name' => $request->name
        ]);

        return redirect('indication');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Indication $indication)
    {
        $indication->delete();

        return redirect('indication');
    }
}
