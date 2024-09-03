<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AncoModel extends Model
{
    use HasFactory;

    protected $table = 'anco';
    protected $primaryKey = 'id_anco';
    protected $fillable = ['kd_anco', 'tanggal_cek', 'waktu_cek', 'pemberian_pakan','jamPemberian_pakan','kondisi_pakan', 'kondisi_udang', 'catatan', 'id_fase_tambak', 'created_at', 'updated_at'];

public function faseKolam():BelongsTo{
        return $this->belongsTo(FaseKolamModel::class, 'id_fase_tambak');
}
}