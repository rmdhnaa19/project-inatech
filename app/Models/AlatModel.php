<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatModel extends Model
{
    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'id_alat';

    protected $fillable = ['nama', 'harga_satuan', 'satuan', 'deskripsi', 'foto','created_at', 'updated_at'];

    public function detailAlat(){
        return $this->hasMany(DetailAlatModel::class, 'id_alat', 'id_alat');
    }
}
