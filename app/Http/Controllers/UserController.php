<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

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

class UserController extends Controller
{
    public function index()
    // {
    //     $user = UserModel::with('level')->get();
    //     dd($user);
    // }
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

public function tambah()
{
    return view('user_tambah');
}
public function tambah_simpan(Request $request)
{
    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => Hash::make($request->password),
        'level_id' => $request->level_id
    ]);
    return redirect('/user');
}
public function ubah($user_id)
{
    $user = UserModel::find($user_id);
    return view('user_ubah', ['data' => $user]);
    
} 
public function ubah_simpan($id,Request $request)
{
    $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;
        $user->save();
    return redirect('/user');
}
public function hapus($id)
{
    $user = UserModel::find($id);
    $user->delete();
    return redirect('/user');
}
}
// Penjelasan singkat:
// - Kelas UserController mewarisi dari kelas Controller
// - Metode index() mengambil semua data pengguna dari model UserModel
// - Data pengguna dikirim ke tampilan 'user' dengan nama variabel 'data'
// - Tampilan 'user' akan menampilkan daftar semua pengguna