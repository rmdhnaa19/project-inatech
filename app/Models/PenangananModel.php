<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenangananModel extends Model
{
    use HasFactory;

    protected $table = 'penanganan';
    protected $primaryKey = 'id_penanganan';
    protected $fillable = ['kd_penanganan', 'tanggal_cek', 'waktu_cek', 'pemberian_mineral','pemberian_vitamin','pemberian_obat', 'penambahan_air', 'pengurangan_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at'];

public function faseKolam():BelongsTo{
        return $this->belongsTo(FaseKolamModel::class, 'id_fase_tambak', 'id_fase_tambak');
}
}