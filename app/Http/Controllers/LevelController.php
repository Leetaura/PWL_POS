<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level pengguna dalam sistem'
        ];

        $activeMenu = 'level';

        $level = LevelModel::all();

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_nama', 'level_kode')
        ->with('users');

        if ($request->level_nama) {
            $levels->where('level_nama', $request->level_nama);
        }

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$level->level_id).'">'
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
        return view('level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_nama' => 'required|string|max:100', // Nama level harus diisi, maksimal 100 karakter
        ]);

        LevelModel::create([
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Level baru berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $level = LevelModel::findorFail($id);
        return view('level.show', compact('level'));
    }

    public function edit(string $id)
    {
        $level = LevelModel::findorFail($id);
        return view('level.edit', compact('level'));
    }

    public function update(string $id, Request $request)
    {
        $request->validate([
            'level_nama' => 'required|string|max:100', // Nama level harus diisi, maksimal 100 karakter
            'level_kode' => 'required|string|max:10', // Kode level harus diisi, maksimal 10 karakter
        ]);

        LevelModel::findorFail($id)->update([
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Level berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::findorFail($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Level tidak ditemukan');
        }
        try {
            LevelModel::destroy($id);

            return redirect('/level')->with('success', 'Level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/level')->with('error', 'Level gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
        }
    }
}
