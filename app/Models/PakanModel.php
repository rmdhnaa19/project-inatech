<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PakanModel extends Model
{
    use HasFactory;

    protected $table = 'pakan';
    protected $primaryKey = 'id_pakan';

    protected $fillable = ['gambar', 'nama', 'harga_satuan', 'satuan' , 'deskripsi', 'created_at', 'updated_at'];
}
