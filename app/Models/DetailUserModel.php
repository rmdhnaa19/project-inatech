<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailUserModel extends Model
{
    use HasFactory;

    protected $table = 'detail_user';
    protected $primaryKey = 'id_detail_user';

    protected $fillable = ['kd_detail_user', 'id_gudang', 'id_user', 'created_at', 'updated_at'];

    public function gudang():BelongsTo{
        return $this->belongsTo(GudangModel::class, 'id_gudang', 'id_gudang');
    }

    public function user():BelongsTo{
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }
}
