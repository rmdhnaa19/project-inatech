<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangModel extends Model
{
    use HasFactory;

    protected $table = 'gudang';
    protected $primaryKey = 'id_gudang';
    protected $fillable = ['gambar', 'nama', 'panjang', 'lebar','luas', 'alamat', 'created_at', 'updated_at'];
}
