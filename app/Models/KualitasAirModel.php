<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KualitasAirModel extends Model
{
    use HasFactory;

    protected $table = 'kualitas_air';
    protected $primaryKey = 'id_kualitas_air';
    protected $fillable = ['kd_kualitas_air', 'tanggal_cek', 'waktu_cek', 'pH','salinitas','DO', 'suhu', 'kejernihan_air', 'warna_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at'];

public function faseKolam():BelongsTo{
        return $this->belongsTo(FaseKolamModel::class, 'id_fase_tambak');
}
}