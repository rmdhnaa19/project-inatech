<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TambakModel extends Model
{
    use HasFactory;

    protected $table = 'tambak';
    protected $primaryKey = 'id_tambak';
    protected $fillable = ['gambar', 'nama_tambak', 'luas_lahan', 'luas_tambak','lokasi_tambak', 'created_at', 'updated_at'];
}
