<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang dalam sistem'
        ];

        $activeMenu = 'barang';

        $kategori = DB::table('m_barang')->get();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategoris = DB::table('m_barang')
        ->select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->where('barang_nama', 'like', '%' . $request->barang_nama . '%');

        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="'.url('/barang/' . $kategori->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $kategori->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/barang/'.$kategori->barang_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->addColumn('harga_beli', function ($kategori) {
                return 'Rp ' . number_format($kategori->harga_beli, 0, ',', '.');
            })
            ->addColumn('harga_jual', function ($kategori) {
                return 'Rp ' . number_format($kategori->harga_jual, 0, ',', '.');
            })
            ->rawColumns(['aksi', 'harga_beli', 'harga_jual'])
            ->make(true);
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:10', // Kode barang harus diisi, maksimal 10 karakter
            'barang_nama' => 'required|string|max:100', // Nama barang harus diisi, maksimal 100 karakter
            'harga_beli' => 'required|integer', // Harga beli harus diisi dan berupa angka
            'harga_jual' => 'required|integer', // Harga jual harus diisi dan berupa angka
        ]);

        DB::table('m_barang')->insert([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Barang baru berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $barang = DB::table('m_barang')->where('barang_id', $id)->first();
        return view('barang.show', compact('barang'));
    }

    public function edit(string $id)
    {
        $barang = DB::table('m_barang')->where('barang_id', $id)->first();
        return view('barang.edit', compact('barang'));
    }

    public function update(string $id, Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:10', // Kode barang harus diisi, maksimal 10 karakter
            'barang_nama' => 'required|string|max:100', // Nama barang harus diisi, maksimal 100 karakter
            'harga_beli' => 'required|integer', // Harga beli harus diisi dan berupa angka
            'harga_jual' => 'required|integer', // Harga jual harus diisi dan berupa angka
        ]);

        DB::table('m_barang')->where('barang_id', $id)->update([
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Barang berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = DB::table('m_barang')->where('barang_id', $id)->first();
        if (!$check) {
            return redirect('/barang')->with('error', 'Barang tidak ditemukan');
        }
        try {
            DB::table('m_barang')->where('barang_id', $id)->delete();

            return redirect('/barang')->with('success', 'Barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/barang')->with('error', 'Barang gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
        }
    }
}
