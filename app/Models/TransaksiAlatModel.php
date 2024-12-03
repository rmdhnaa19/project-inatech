<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiAlatModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi_alat';
    protected $primaryKey = 'id_transaksi_alat';

    protected $fillable = ['kd_transaksi_alat', 'tipe_transaksi', 'quantity', 'id_detail_alat', 'created_at', 'updated_at'];

    public function detailAlat():BelongsTo{
        return $this->belongsTo(DetailAlatModel::class, 'id_detail_alat', 'id_detail_alat');
    }
}
