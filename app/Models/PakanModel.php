<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PakanModel extends Model
{
    use HasFactory;

    protected $table = 'pakan';
    protected $primaryKey = 'id_pakan';

    protected $fillable = ['nama', 'harga_satuan', 'satuan' , 'foto','deskripsi', 'created_at', 'updated_at'];

    public function pakan_harians(){
        return $this->hasMany(PakanHarianModel::class,'id_detail_pakan');
    }

    public function detailPakan(){
        return $this->hasMany(DetailPakanModel::class, 'id_pakan', 'id_pakan');
    }
}
