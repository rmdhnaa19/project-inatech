<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPakanModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pakan';
    protected $primaryKey = 'id_transaksi_pakan';

    protected $fillable = ['kd_transaksi_pakan', 'tipe_transaksi', 'quantity', 'id_detail_pakan', 'created_at', 'updated_at'];

    public function detailPakan():BelongsTo{
        return $this->belongsTo(DetailPakanModel::class, 'id_detail_pakan', 'id_detail_pakan');
    }
}
