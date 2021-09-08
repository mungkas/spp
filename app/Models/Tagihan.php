<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    //

    use SoftDeletes;

    protected $table = 'tagihan';

    protected $fillable = [
        'nama',
        'jumlah',
        'wajib_semua',
        'jenjang_id'
        // 'tgl_mulai',
        // 'tgl_selesai'
    ];

    public function transaksi(){
        return $this->hasMany('App\Models\Transaksi','tagihan_id','id');
    }

    public function transaksiToday(){
        return $this->transaksi()->whereDate('created_at', now()->today());
    }

    public function role(){
        return $this->hasMany('App\Models\Role','tagihan_id','id');
    }

    public function siswa(){
        return $this->belongsToMany('App\Models\Siswa','role');
    }

    public function jenjang(){
        return $this->hasOne('App\Models\Jenjang','id','jenjang_id');
    }

    public function getJumlahIdrAttribute(){
        return "IDR. ".format_idr($this->jumlah);
    }
}
