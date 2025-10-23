<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventarisRequest;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventarisControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Inventaris::paginate(20);
        return Inertia::render('inventaris/Index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('inventaris/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventarisRequest $request)
    {
        Inventaris::create($request->validated());
        return to_route('inventaris.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Inventaris::find($id);
        return Inertia::render('inventaris/Form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventarisRequest $request, string $id)
    {
        $data = Inventaris::find($id);
        $data->update($request->validated());
        return to_route('inventaris.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Inventaris::find($id)->delete();
        return to_route('inventaris.index');
    }
}
