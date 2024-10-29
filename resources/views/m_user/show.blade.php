@extends('m_user/template')

@section('content')
<div class="row mt-5 mb-5">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
        <h2>Show User</h2>
        </div>
        <div class="float-right">
        <a href="{{ route('m_user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>User id:</strong>
                    {{ $m_user->user_id }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Level id:</strong>
                    {{ $m_user->level_id }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Username:</strong>
                    {{ $m_user->username }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="group">
                    <strong>Nama:</strong>
                    {{ $m_user->nama }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    {{ $m_user->password }}
                </div>
            </div>
        </div>
@endsection