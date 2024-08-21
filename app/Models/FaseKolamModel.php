<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaseKolamModel extends Model
{
    use HasFactory;

    protected $table = 'fase_tambak';
    protected $primaryKey = 'id_fase_tambak';
    protected $fillable = ['kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar','densitas','id_kolam', 'created_at', 'updated_at'];

public function kolam():BelongsTo{
        return $this->belongsTo(KolamModel::class, 'id_kolam', 'id_kolam');
}
}