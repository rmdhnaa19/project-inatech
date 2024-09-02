<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SamplingModel extends Model
{
    use HasFactory;

    protected $table = 'sampling';
    protected $primaryKey = 'id_sampling';
    protected $fillable = ['kd_sampling', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','size_udang', 'interval_hari', 'harga_udang', 'input_fr', 'total_pakan', 'ADG_udang', 'biomassa', 'populasi_ekor', 'catatan','id_fase_tambak', 'created_at', 'updated_at'];

public function faseKolam():BelongsTo{
        return $this->belongsTo(FaseKolamModel::class, 'id_fase_tambak', 'id_fase_tambak');
}
}