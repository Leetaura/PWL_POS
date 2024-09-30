<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>user_tambah</title>
</head>
<body>
    <h2>Form Tambah Data User</h2>
    <form action="/user/tambah_simpan" method="POST">
        @csrf
        <label>Username:</label>
        <input type="text" name="username" placeholder="Masukkan username">
        <br>
        <label>Nama:</label>
        <input type="text" name="nama" placeholder="Masukkan nama">
        <br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="Masukkan password">
        <br>
        <label>Level ID:</label>
        <input type="number" name="level_id" placeholder="Masukkan  ID  level">
        <br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>