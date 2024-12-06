<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['id_role', 'username', 'password', 'nama', 'no_hp', 'alamat', 'gaji_pokok', 'komisi', 'tunjangan', 'potongan_gaji', 'posisi', 'foto', 'remember_token','created_at', 'updated_at'];

    public function role():BelongsTo{
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function detailUser():HasMany{
        return $this->hasMany(DetailUserModel::class, 'id_user', 'id_user');
    }
    public function userTambak():HasMany{
        return $this->hasMany(PjTambakModel::class, 'id_user', 'id_user');
    }
}
