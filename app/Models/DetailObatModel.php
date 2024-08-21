<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailObatModel extends Model
{
    use HasFactory;

    protected $table = 'detail_obat';
    protected $primaryKey = 'id_detail_obat';

    protected $fillable = ['kd_detail_obat', 'id_gudang', 'id_obat', 'stok_obat', 'created_at', 'updated_at'];

    public function gudang():BelongsTo{
        return $this->belongsTo(GudangModel::class, 'id_gudang', 'id_gudang');
    }
    public function obat():BelongsTo{
        return $this->belongsTo(ObatModel::class, 'id_obat', 'id_obat');
    }
}
