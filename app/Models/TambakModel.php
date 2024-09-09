<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TambakModel extends Model
{
    use HasFactory;

    protected $table = 'tambak';
    protected $primaryKey = 'id_tambak';
    protected $fillable = ['foto', 'nama_tambak', 'id_gudang','luas_lahan', 'luas_tambak','lokasi_tambak', 'created_at', 'updated_at'];
    
    public function gudang():BelongsTo{
        return $this->belongsTo(GudangModel::class, 'id_gudang', 'id_gudang');

}
}