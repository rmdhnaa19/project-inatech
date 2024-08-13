<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['id_role', 'username', 'password', 'nama', 'no_hp', 'alamat', 'gaji_pokok', 'komisi', 'tunjangan', 'potongan_gaji', 'posisi','created_at', 'updated_at'];

    public function role():BelongsTo{
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }
}
