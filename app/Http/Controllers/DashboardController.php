<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_kk' => KartuKeluarga::count(),
            'total_warga' => Penduduk::count(),
        ];

        return Inertia::render('Dashboard', [
            'data' => $data
        ]);
    }

    
}
