@extends('layout.app')

@section('subtitle', 'Manager')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Manager')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tampilan <?php echo (Auth::user()->level_id == 1) ? 'Admin' : 'Manager'; ?></div>
        <div class="card-body">
            <h2>Login Sebagai: <?php echo (Auth::user()->level_id == 1) ? 'Admin' : 'Manager'; ?></h2>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    </div>
</div>

@endsection
@push('js')
@endpush
