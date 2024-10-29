@extends('m_user/template')
@section('content')
<div class="row mt-5 mb-5">
 <div class="col-lg-12 margin-tb">
 <div class="float-left">
 <h2>Edit User</h2>
 </div>
 <div class="float-right">
 <a class="btn btn-secondary" href="{{ route('m_user.index') }}"> Kembali</a>
</div>
</div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
<strong>Ops!</strong> Error <br><br>
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('m_user.update', $m_user->user_id) }}" method="POST">
@csrf
@method('PUT')
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>User_id:</strong>
<input type="text" name="userid" value="{{ $m_user->user_id }}" class="formcontrol" placeholder="Masukkan user id">
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Level_id:</strong>
<input type="text" name="levelid" value="{{ $m_user->level_id }}" class="formcontrol" placeholder="Masukkan level">
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Username:</strong>
<input type="text" value= "{{ $m_user->username }}" class="form-control"
name="username" placeholder="Masukkan Nomor username">
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>nama:</strong>
<input type="text" value= "{{ $m_user->nama }}"name="nama" class="form-control"
placeholder="Masukkan nama"></input>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Password:</strong>
<input type="password" value= "{{ $m_user->password }}"name="password"
class="form-control" placeholder="Masukkan password"></input>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" class="btn btn-primary">Update</button>
</div>
</div>
</form>
@endsection