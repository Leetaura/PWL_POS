<?php
namespace App\Http\Controllers;

class welcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' =>'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome2', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}