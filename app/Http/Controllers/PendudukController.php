<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PendudukRequest;
use App\Http\Requests\KartuKeluargaRequest;
use Illuminate\Support\Facades\Cache;

class PendudukController extends Controller
{
    public function search($key)
    {
        $data = Penduduk::select('id', 'nama_lengkap', 'pendidikan')->where('nama_lengkap', 'like', '%' . $key . '%')->get();
        return response()->json($data);
    }
    public function searchkartuKeluarga($key)
    {
        $data = KartuKeluarga::select('id', 'kepala_keluarga', 'nomor')
        ->where('kepala_keluarga', 'like', '%' . $key . '%')
        ->get();
        return response()->json($data);
    }
    public function list(Request $request)
    {
        $data = Penduduk::select(
            'nomor',
            'nama_lengkap',
            'nik',
            'Jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'pendidikan',
            'jenis_pekerjaan',
            'golongan_darah',
            'status_perkawinan',
            'tanggal_perkawinan',
            'status_hubungan_keluarga',
            'kewarganegaraan',
            'no_paspor',
            'no_kitap',
            'nama_ayah',
            'nama_ibu',
        )
            ->when($request->search, function ($q) use ($request) {
                $q->where('penduduk.nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('penduduk.nik', $request->search)
                    ->orWhere('kk.nomor', $request->search);
            })
            ->join('kartu_keluarga as kk', 'kk.id', 'penduduk.kartu_keluarga_id')
            ->paginate(10);
        return Inertia::render('penduduk/List', compact('data'));
    }

    public function index(Request $request)
    {
        $data = KartuKeluarga::withCount('items')
            ->when($request->search, function ($q) use ($request) {
                $q->where('kepala_keluarga', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor', $request->search);
            })
            ->paginate(10);
        return Inertia::render('penduduk/Index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('penduduk/Form');
    }
    /**
     * Show the form for creating a new resource.
     */

    public function createItem($id)
    {
        $data = KartuKeluarga::find($id);
        return Inertia::render('penduduk/FormItem', compact('data'));
    }
    public function editItem($id, $itemId)
    {
        $data = KartuKeluarga::find($id);
        $item = Penduduk::find($itemId);
        return Inertia::render('penduduk/FormItem', compact('data', 'item'));
    }
    public function storeItem(PendudukRequest $request, $id)
    {
        try {
            $data = KartuKeluarga::find($id);
            $validated = $request->validated();
            // dd($validated);
            $data->items()->create($validated);
            return redirect()->route('penduduk.show', $id);
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
    public function updateItem(PendudukRequest $request, $id, $itemId)
    {
        $data = Penduduk::find($itemId);
        $validated = $request->validated();
        $data->update($validated);
        return redirect()->route('penduduk.show', $id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KartuKeluargaRequest $request)
    {
        $validated = $request->validated();

        $data = KartuKeluarga::create($validated);

        return redirect()->route('penduduk.show', $data->id);
    }
    public function updateKartuKeluarga(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluarga,id'],
            'penduduk_id' => ['required', 'exists:penduduk,id'],
        ]);

        $kk = KartuKeluarga::findOrFail($request->kartu_keluarga_id);
        $penduduk = Penduduk::find($request->penduduk_id);
        $penduduk->update([
            'kartu_keluarga_id' => $kk->id
        ]);

        return redirect()->route('penduduk.show', $kk->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = KartuKeluarga::find($id);
        $items = Penduduk::where('kartu_keluarga_id', $id)->get();
        $columns = [
            'nama_lengkap',
            'nik',
            'Jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'pendidikan',
            'jenis_pekerjaan',
            'golongan_darah',
            'status_perkawinan',
            'tanggal_perkawinan',
            'status_hubungan_keluarga',
            'kewarganegaraan',
            // 'no_paspor',
            // 'no_kitap',
            'nama_ayah',
            'nama_ibu'
        ];
        return Inertia::render('penduduk/Show', compact('data', 'items', 'columns'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = KartuKeluarga::find($id);
        return Inertia::render('penduduk/Form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KartuKeluargaRequest $request, string $id)
    {
        $validated = $request->validated();

        $data = KartuKeluarga::find($id);
        $data->update($validated);

        return redirect()->route('penduduk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUsiaChart()
    {
        $today = Carbon::today();

        $data = Cache::remember('charts-penduduk', 3000, function () use ($today) {
            return  DB::table('penduduk')
                ->select('tanggal_lahir')
                ->get()
                ->map(function ($item) use ($today) {
                    $item->usia = Carbon::parse($item->tanggal_lahir)->age;
                    return $item;
                });
        });
        $anak = $data->whereBetween('usia', [0, 12])->count();
        $remaja = $data->whereBetween('usia', [13, 17])->count();
        $dewasa = $data->whereBetween('usia', [18, 59])->count();
        $orangtua = $data->where('usia', '>=', 60)->count();

        return response()->json([
            'labels' => ['Anak-anak (0-12)', 'Remaja (13-17)', 'Dewasa (18-59)', 'Orang Tua (60+)'],
            'data' => [$anak, $remaja, $dewasa, $orangtua],
        ]);
    }
    public function getJenisKelaminChart()
    {
        $data = Cache::remember('jenis_kelamin_chart', 1000, function () {
            return [
                'laki' => DB::table('penduduk')->where('jenis_kelamin', 'like', 'laki%')->count(),
                'perempuan' => DB::table('penduduk')->where('jenis_kelamin', 'like', 'perempuan%')->count()
            ];
        });

        return response()->json([
            'labels' => ['Laki Laki', 'Perempuan'],
            'data' => [$data['laki'], $data['perempuan']]
        ]);
    }
}
