<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = DB::table('m_kategori')->get();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategoris = DB::table('m_kategori')
        ->select('kategori_id', 'kategori_kode', 'kategori_nama')
        ->where('kategori_nama', 'like', '%' . $request->kategori_nama . '%');

        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/kategori/'.$kategori->kategori_id).'">'
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
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10', // Kode kategori harus diisi, maksimal 10 karakter
            'kategori_nama' => 'required|string|max:100', // Nama kategori harus diisi, maksimal 100 karakter
        ]);

        DB::table('m_kategori')->insert([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori baru berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $kategori = DB::table('m_kategori')->where('kategori_id', $id)->first();
        return view('kategori.show', compact('kategori'));
    }

    public function edit(string $id)
    {
        $kategori = DB::table('m_kategori')->where('kategori_id', $id)->first();
        return view('kategori.edit', compact('kategori'));
    }

    public function update(string $id, Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10', // Kode kategori harus diisi, maksimal 10 karakter
            'kategori_nama' => 'required|string|max:100', // Nama kategori harus diisi, maksimal 100 karakter
        ]);

        DB::table('m_kategori')->where('kategori_id', $id)->update([
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = DB::table('m_kategori')->where('kategori_id', $id)->first();
        if (!$check) {
            return redirect('/kategori')->with('error', 'Kategori tidak ditemukan');
        }
        try {
            DB::table('m_kategori')->where('kategori_id', $id)->delete();

            return redirect('/kategori')->with('success', 'Kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/kategori')->with('error', 'Kategori gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
        }
    }
}
