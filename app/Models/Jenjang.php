<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenjang extends Model
{
    //
    use SoftDeletes;

    protected $table = 'jenjang';

    protected $fillable = [
        'periode_id',
        'nama'
    ];

    public function siswa(){
        return $this->hasMany('App\Models\Siswa','jenjang_id','id');
    }

    public function periode(){
        return $this->hasOne('App\Models\Periode','id','periode_id');
    }
}
