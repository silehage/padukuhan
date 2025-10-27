<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penduduk;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $options = Cache::remember('pengurus_potions', 600, function () {
            return Pengurus::all()->map(function ($item) {
                return [
                    'label' => $item->jabatan,
                    'value' => $item->id
                ];
            });
        });

        $data = Penduduk::select(
            'penduduk.*',
            'pengurus.jabatan'
        )->join('pengurus', 'pengurus.id', 'penduduk.pengurus_id')
            ->when($request->search, function ($q) use ($request) {
                $searchKey = '%' . $request->search . '%';
                $q->where('penduduk.nama_lengkap', 'like', $searchKey);
            })
            ->orderBy('pengurus.id')
            ->paginate(10);

        $penduduk = Cache::remember('penduduk_options', 600, function () {
            return DB::table('penduduk')
                ->select('id', 'nama_lengkap')->get()
                ->map(function ($item) {
                    return [
                        'label' => $item->nama_lengkap,
                        'value' => $item->id
                    ];
                });
        });

        return Inertia::render('pengurus/Index', compact('data', 'penduduk', 'options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        return to_route('pengurus.index');
    }

    public function assignPengurus(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required',
            'pengurus_id' => 'nullable',
        ]);

        Penduduk::where('id', $request->penduduk_id)->update([
            'pengurus_id' => $request->pengurus_id ?? NULL
        ]);;

        $this->clearCache();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengurus $pengurus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengurus $pengurus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $pengurus)
    {
        //
    }

    protected function clearCache()
    {
        Cache::forget('pengurus_potions');
        Cache::forget('penduduk_options');
    }
}
