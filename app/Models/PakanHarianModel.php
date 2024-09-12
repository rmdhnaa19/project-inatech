<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PakanHarianModel extends Model
{
    use HasFactory;

    protected $table = 'pakan_harian';
    protected $primaryKey = 'id_pakan_harian';
    protected $fillable = ['kd_pakan_harian', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','total_pakan', 'catatan', 'id_fase_tambak','id_detail_pakan', 'created_at', 'updated_at'];

public function faseKolam():BelongsTo{
        return $this->belongsTo(FaseKolamModel::class, 'id_fase_tambak');
}
public function detailPakan():BelongsTo{
        return $this->belongsTo(DetailPakanModel::class, 'id_detail_pakan');
}

}