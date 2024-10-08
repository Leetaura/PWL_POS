<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'kategori_kode' => 'SNK',
            'kategori_nama' => 'Snack/Makanan Ringan',
            'created_at' => now()  // Corrected from 'create_at' to 'created_at'
        ];

        DB::table('m_kategori')->insert($data);

        return 'Insert data baru berhasil';
    }
}
