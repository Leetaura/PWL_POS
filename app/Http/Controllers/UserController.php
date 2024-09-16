<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dari database
        $user = UserModel::all();

        // Tampilkan data pengguna dalam view 'user'
        return view('user',['data' => $user]);
    }
}
