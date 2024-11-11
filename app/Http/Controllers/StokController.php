<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok dalam sistem'
        ];

        $activeMenu = 'stok';

        $stok = DB::table('t_stok')->get();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = DB::table('t_stok')
        ->select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
        ->where('stok_tanggal', 'like', '%' . $request->stok_tanggal . '%');

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/stok/'.$stok->stok_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('stok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer', // ID barang harus diisi dan harus berupa angka
            'user_id' => 'required|integer', // ID user harus diisi dan harus berupa angka
            'stok_tanggal' => 'required|date', // Tanggal stok harus diisi dan harus berupa tanggal
            'stok_jumlah' => 'required|integer', // Jumlah stok harus diisi dan harus berupa angka
        ]);

        DB::table('t_stok')->insert([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Stok baru berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $stok = DB::table('t_stok')->where('stok_id', $id)->first();
        return view('stok.show', compact('stok'));
    }

    public function edit(string $id)
    {
        $stok = DB::table('t_stok')->where('stok_id', $id)->first();
        return view('stok.edit', compact('stok'));
    }

    public function update(string $id, Request $request)
    {
        $request->validate([
            'stok_tanggal' => 'required|date', // Tanggal stok harus diisi dan harus berupa tanggal
            'stok_jumlah' => 'required|integer', // Jumlah stok harus diisi dan harus berupa angka
        ]);

        DB::table('t_stok')->where('stok_id', $id)->update([
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Stok berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = DB::table('t_stok')->where('stok_id', $id)->first();
        if (!$check) {
            return redirect('/stok')->with('error', 'Stok tidak ditemukan');
        }
        try {
            DB::table('t_stok')->where('stok_id', $id)->delete();

            return redirect('/stok')->with('success', 'Stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/stok')->with('error', 'Stok gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
        }
    }
}
