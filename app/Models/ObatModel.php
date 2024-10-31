<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatModel extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = ['nama', 'harga_satuan', 'satuan', 'deskripsi', 'foto','created_at', 'updated_at'];
}
