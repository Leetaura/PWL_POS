<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah Data User</title>
</head>
<body>
    <h1>Ubah Data User</h1>
    <form action="/user/ubah_simpan/{{ $data->user_id }}" method="POST">
        @csrf
        @method('PUT')
        <label>Username:</label>
        <input type="text" name="username" value="{{ $data->username }}" placeholder="Masukkan username">
        <br>
        <label>Nama:</label>
        <input type="text" name="nama" value="{{ $data->nama }}" placeholder="Masukkan nama">
        <br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="Masukkan password baru (opsional)">
        <br>
        <label>Level ID:</label>
        <input type="number" name="level_id" value="{{ $data->level_id }}" placeholder="Masukkan ID level">
        <br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>