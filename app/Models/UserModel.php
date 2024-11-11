<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class);
    }
}

// Penjelasan singkat:
// - Metode 'level()' mendefinisikan relasi "belongs to" antara UserModel dan LevelModel.
// - Ini berarti setiap user memiliki satu level.
// - Metode ini mengembalikan objek BelongsTo, yang memungkinkan akses ke data level terkait.
// - Penggunaan: $user->level akan mengembalikan objek LevelModel yang terkait dengan user tersebut.