<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiObatModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi_obat';
    protected $primaryKey = 'id_transaksi_obat';

    protected $fillable = ['kd_transaksi_obat', 'tipe_transaksi', 'quantity', 'id_detail_obat', 'created_at', 'updated_at'];

    public function detail_obat():BelongsTo{
        return $this->belongsTo(DetailObatModel::class, 'id_detail_obat', 'id_detail_obat');
    }
}
