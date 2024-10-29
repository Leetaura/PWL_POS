@extends('m_user/template')
@section('content')

<div class="row mt-5 mb-5">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2>CRUD User</h2>
        </div>
        <div class="float-right">
            <a href="{{ route('m_user.create') }}" class="btn btn-success">Input User</a>
        </div>
    </div>
</div>

    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
            <tr>
                <th width="200px" class="text-center">User id</th>
                <th width="150px" class="text-center">Level id</th>
                <th width="200px" class="text-center">Username</th>
                <th width="200px" class="text-center">Nama</th>
                <th width="150px" class="text-center">Password</th>
            </tr>
            @foreach($m_user as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->level_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->password }}</td>
                <td class="text-center">
                    <form action="{{ route('m_user.destroy', $user->user_id) }}" method="POST">
                        <a href="{{ route('m_user.show', $user->user_id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('m_user.edit', $user->user_id) }}" class="btn btn-primary btn-sm">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
    </table>
@endsection