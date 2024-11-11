<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'pembeli', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')
        ->with('user');

        if ($request->pembeli) {
            $penjualans->where('pembeli', $request->pembeli);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/penjualan/'.$penjualan->penjualan_id).'">'
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
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:50', // Nama pembeli harus diisi, maksimal 50 karakter
            'penjualan_kode' => 'required|string|max:20', // Kode penjualan harus diisi, maksimal 20 karakter
        ]);

        PenjualanModel::create([
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
        ]);

        return redirect('/penjualan')->with('success', 'Penjualan baru berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $penjualan = PenjualanModel::findorFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(string $id)
    {
        $penjualan = PenjualanModel::findorFail($id);
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(string $id, Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:50', // Nama pembeli harus diisi, maksimal 50 karakter
            'penjualan_kode' => 'required|string|max:20', // Kode penjualan harus diisi, maksimal 20 karakter
        ]);

        PenjualanModel::findorFail($id)->update([
            'pembeli' => $request->pembeli,
        ]);

        return redirect('/penjualan')->with('success', 'Penjualan berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = PenjualanModel::findorFail($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Penjualan tidak ditemukan');
        }
        try {
            PenjualanModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/penjualan')->with('error', 'Penjualan gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
        }
    }
}
