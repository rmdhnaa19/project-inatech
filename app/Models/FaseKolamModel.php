<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaseKolamModel extends Model
{
    use HasFactory;

    protected $table = 'fase_tambak';
    protected $primaryKey = 'id_fase_tambak';
    protected $fillable = ['kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar','densitas', 'foto','id_kolam', 'created_at', 'updated_at'];

public function kolam():BelongsTo{
        return $this->belongsTo(KolamModel::class, 'id_kolam', 'id_kolam');
}
    public function ancos()
    {
        return $this->hasMany(AncoModel::class, 'id_fase_tambak');
    }

public function kualitasairs() 
    {
        return $this->hasMany(KualitasAirModel::class, 'id_fase_tambak');
    }

public function penanganans() 
    {
        return $this->hasMany(PenangananModel::class, 'id_fase_tambak');
    }

public function samplings() 
    {
        return $this->hasMany(SamplingModel::class, 'id_fase_tambak');
    }

public function pakan_harians() 
    {
        return $this->hasMany(PakanHarianModel::class,'id_fase_tambak');
    }

public function kematianudangs() 
    {
        return $this->hasMany(KematianUdangModel::class,'id_fase_tambak');
    }   
    
}
