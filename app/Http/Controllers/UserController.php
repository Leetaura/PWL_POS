<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

            if ($request->level_id) {
                $users->where('level_id', $request->level_id);
            }

        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
{
    // Validasi data yang dikirimkan
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username', // Username harus diisi, minimal 3 karakter, unik
        'nama'     => 'required|string|max:100',                   // Nama harus diisi, maksimal 100 karakter
        'password' => 'required|min:5',                           // Password harus diisi, minimal 5 karakter
        'level_id'  => 'required|integer',                        // Level ID harus diisi dan berupa angka
    ]);

    // Simpan data ke dalam database
    UserModel::create([
        'username' => $request->username,
        'nama'     => $request->nama,
        'password' => bcrypt($request->password), // Enkripsi password sebelum disimpan
        'level_id'  => $request->level_id,
    ]);

    // Redirect kembali ke halaman user dengan pesan sukses
    return redirect('/user')->with('success', 'Data user berhasil disimpan');
}
public function show(string $id)
{
    $user = UserModel::findorFail($id);

    $breadcrumb = (object) [
        'title' => 'Detail User',
        'list' => ['Home', 'User', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail user '
    ];

    $activeMenu = 'user';

    return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
}
public function edit(string $id)
{
    $user = UserModel::findorFail($id);
    $level = LevelModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit User',
        'list' => ['Home', 'User', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit user'
    ];

    $activeMenu = 'user';

    return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
}

public function update(string $id, Request $request)
{
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username,'.$id. ',user_id',
        'nama' => 'required|string|max:100',
        'password' => 'required|min:5',
        'level_id' => 'required|integer',
    ]);

    UserModel::findorFail($id)->update([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => $request->password ? bcrypt($request->password) : UserModel::findorFail($id)->password,
        'level_id' => $request->level_id,
    ]);
    
    return redirect('/user')->with('success', 'Data user berhasil diubah');
}
public function destroy(string $id)
{
    $check = UserModel::findorFail($id);
    if (!$check) {
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }
    try {
        UserModel::destroy($id);

        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {

        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel yang terkait dengan data ini');
    }
}
}
// class UserController extends Controller
// {
//     public function index()
//     {
//         $data = [
//             'level_id' => 2,
//             'username' => 'manager_tiga',
//             'nama' => 'Manager 3',
//             'password' => Hash::make('12345')
//         ];
//         UserModel::create($data);
//         // Ambil semua data pengguna dari database
//         $user = UserModel::all();

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::find(1);

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::where('level_id', 1)->first();

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::firstWhere('level_id', 1);

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::findOr(20, ['username', 'nama',], function (){
//             abort(404);
//         });

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::findOrFail(1);

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil semua data pengguna dari database
//         $user = UserModel::where('username', 'manager9')->firstOrFail();

//         // Tampilkan data pengguna dalam view 'user'
//         return view('user',['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil jumlah pengguna dengan level_id 2 dari database
//         $jumlahUser = UserModel::where('level_id', 2)->count();
        
//         // Tampilkan jumlah pengguna dalam view 'user'
//         return view('user', ['jumlahUser' => $jumlahUser]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil data pengguna dari database atau buat baru jika tidak ada
//         $user = UserModel::firstOrCreate(
//             [
//                 'username' => 'manager22',
//                 'nama' => 'manager dua dua',
//                 'password' => Hash::make('12345'),
//                 'level_id' => 2
//             ],
//         );
        
//         // Tampilkan data pengguna dalam view 'user'
//         return view('user', ['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil data pengguna dari database atau buat baru jika tidak ada
//         $user = UserModel::firstOrNew(
//             [
//                 'username' => 'manager33',
//                 'nama' => 'manager tiga tiga',
//                 'password' => Hash::make('12345'),
//                 'level_id' => 2
//             ],
//         );
//         // Menyimpan data pengguna ke dalam database
//         // Metode save() akan menyimpan data baru jika belum ada,
//         // atau memperbarui data yang sudah ada jika ditemukan
//         $user->save();
        
//         // Tampilkan data pengguna dalam view 'user'
//         return view('user', ['data' => $user]);
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil data pengguna dari database atau buat baru jika tidak ada
//         $user = UserModel::create(
//             [
//                 'username' => 'manager55',
//                 'nama' => 'manager55 ',
//                 'password' => Hash::make('12345'),
//                 'level_id' => 2
//             ],
//         );
//         $user->username = 'manager56';

//         $user->isDirty(); //true
//         $user->isDirty('username'); //true
//         $user->isDirty('nama'); //false
//         $user->isDirty(['nama','username']); //true
        
//         $user->isClean(); //false
//         $user->isClean('username'); //false
//         $user->isClean('nama'); //true
//         $user->isClean(['nama','username']); //false

//         $user->save();

//         $user->isDirty(); //false
//         $user->isClean(); //true
        
//         dd($user->isDirty());
        
//     }
// }

// class UserController extends Controller
// {
//     public function index()
//     {
//         // Ambil data pengguna dari database atau buat baru jika tidak ada
//         $user = UserModel::create(
//             [
//                 'username' => 'manager111',
//                 'nama' => 'manager111',
//                 'password' => Hash::make('12345'),
//                 'level_id' => 2
//             ],
//         );
//         $user->username = 'manager121';

//         $user->save();

//         $user->wasChanged(); //true
//         $user->wasChanged('username'); //true
//         $user->wasChanged(['username','level_id']); //true
//         $user->wasChanged('nama'); //false
//         dd($user->wasChanged(['nama','username'])); //true
//         // Tampilkan data pengguna dalam view 'user'
//         // return view('user', ['data' => $user]);
//     }
// }

// Penjelasan:
// $user->wasChanged(['nama','username']) menampilkan true karena:
// - 'username' diubah dari 'manager111' menjadi 'manager121'.
// - wasChanged() mengembalikan true jika minimal satu atribut berubah.
// - Perubahan terdeteksi setelah $user->save() dipanggil.

// Penjelasan singkat:
// Hasil dari $user->wasChanged(['nama','username']) seharusnya true, bukan false.
// Jika hasilnya false, kemungkinan ada beberapa alasan:
// 1. Model tidak benar-benar disimpan ke database (cek apakah $user->save() berhasil).
// 2. Perubahan pada 'username' tidak terdeteksi (cek apakah $user->username = 'manager13' benar-benar mengubah nilai).
// 3. Metode wasChanged() tidak berfungsi sebagaimana mestinya (cek versi Laravel dan dokumentasi terkini).
// 4. Ada masalah dengan konfigurasi atau pengaturan model yang mempengaruhi pelacakan perubahan.

//////////// class UserController extends Controller
// {
//     public function index()
//     // {
//     //     $user = UserModel::with('level')->get();
//     //     dd($user);
//     // }
//     {
//         $user = UserModel::all();
//         return view('user', ['data' => $user]);
//     }

// public function tambah()
// {
//     return view('user_tambah');
// }
// public function tambah_simpan(Request $request)
// {
//     UserModel::create([
//         'username' => $request->username,
//         'nama' => $request->nama,
//         'password' => Hash::make($request->password),
//         'level_id' => $request->level_id
//     ]);
//     return redirect('/user');
// }
// public function ubah($user_id)
// {
//     $user = UserModel::find($user_id);
//     return view('user_ubah', ['data' => $user]);
    
// } 
// public function ubah_simpan($id,Request $request)
// {
//     $user = UserModel::find($id);
//         $user->username = $request->username;
//         $user->nama = $request->nama;
//         $user->password = Hash::make($request->password);
//         $user->level_id = $request->level_id;
//         $user->save();
//     return redirect('/user');
// }
// public function hapus($id)
// {
//     $user = UserModel::find($id);
//     $user->delete();
//     return redirect('/user');
// }
//////////// }
// Penjelasan singkat:
// - Kelas UserController mewarisi dari kelas Controller
// - Metode index() mengambil semua data pengguna dari model UserModel
// - Data pengguna dikirim ke tampilan 'user' dengan nama variabel 'data'
// - Tampilan 'user' akan menampilkan daftar semua pengguna
