<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailAlatModel extends Model
{
    use HasFactory;

    protected $table = 'detail_alat';
    protected $primaryKey = 'id_detail_alat';

    protected $fillable = ['kd_detail_alat', 'id_gudang', 'id_alat', 'stok_alat', 'created_at', 'updated_at'];

    public function gudang():BelongsTo{
        return $this->belongsTo(GudangModel::class, 'id_gudang', 'id_gudang');
    }

    public function alat():BelongsTo{
        return $this->belongsTo(AlatModel::class, 'id_alat', 'id_alat');
    }

    
}
