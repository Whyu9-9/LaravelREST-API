<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Log;

class Obat extends Model
{
    use SoftDeletes;
    
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function logs(){
        return $this->hasMany(Log::class, 'id');
    }

    protected $fillable = [
        'id_user', 'jenis_penyakit', 'img','nama_obat',
        'frekuensi_minum','qty','created_at','updated_at',
    ];

    protected $dates = ['deleted_at'];
}
