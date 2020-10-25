<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Obat;

class Log extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function obat(){
        return $this->belongsTo(Obat::class,'id_obat');
    }

    protected $fillable = [
        'id_obat','created_at','updated_at',
    ];
}
