<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPakanModel extends Model
{
    use HasFactory;

    protected $table = 'detail_pakan';
    protected $primaryKey = 'id_detail_pakan';

    protected $fillable = ['kd_detail_pakan', 'id_gudang', 'id_pakan', 'stok_pakan', 'created_at', 'updated_at'];

    public function gudang():BelongsTo{
        return $this->belongsTo(GudangModel::class, 'id_gudang', 'id_gudang');
    }
    public function pakan():BelongsTo{
        return $this->belongsTo(PakanModel::class, 'id_pakan', 'id_pakan');
    }
}
