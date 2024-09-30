<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dari database
        $user = UserModel::where('username', 'manager9')->firstOrFail();

        // Tampilkan data pengguna dalam view 'user'
        return view('user',['data' => $user]);
    }
}

