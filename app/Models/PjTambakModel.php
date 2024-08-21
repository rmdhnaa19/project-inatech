<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PjTambakModel extends Model
{
    use HasFactory;

    protected $table = 'user_tambak';
    protected $primaryKey = 'id_user_tambak';
    protected $fillable = ['kd_user_tambak', 'id_user', 'id_tambak','created_at', 'updated_at'];

public function tambak():BelongsTo{
        return $this->belongsTo(TambakModel::class, 'id_tambak', 'id_tambak');
}
}