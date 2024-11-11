<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            } 
            else if ($user->level_id == '2') {
                return redirect()->intended('manager');
            }
        }
    
        // Tampilkan halaman login
        return view('login');
    }

    public function proses_login(Request $request)
    {
        // Validasi data input (username dan password wajib diisi)
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba autentikasi pengguna
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            else if ($user->level_id == '2') {
                return redirect()->intended('manager');
            }

            return redirect()->intended('/');
            }
        return redirect('login')
        ->withInput()
        ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }

    public function register()
    {
        // Tampilkan formulir pendaftaran
        return view('register');
    }

    public function proses_register(Request $request)
    {
        // Validasi data input (semua field wajib diisi, username unik)
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required',
        ]);

        // Jika validasi gagal, kembalikan ke formulir dengan pesan error
        if ($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }

        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        UserModel::create($request->all());

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        // Hapus sesi pengguna dan logout
        
        $request->session()->flush();

        Auth::logout();

        // Arahkan ke halaman login
        return redirect('login');
    }
}