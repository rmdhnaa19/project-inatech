<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolamModel extends Model
{
    use HasFactory;

    protected $table = 'kolam';
    protected $primaryKey = 'id_kolam';
    protected $fillable = ['kd_kolam', 'foto', 'tipe_kolam', 'panjang_kolam', 'lebar_kolam','luas_kolam','kedalaman', 'id_tambak','created_at', 'updated_at'];

public function tambak():BelongsTo{
        return $this->belongsTo(TambakModel::class, 'id_tambak', 'id_tambak');
}
}