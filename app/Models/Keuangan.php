<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keuangan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'keuangan';

    protected $fillable = [
        'tabungan_id',
        'transaksi_id',
        'siswa_id',
        'tagihan_id',
        'tipe',
        'jumlah',
        'total_kas',
        'keterangan',
    ];

    public function tabungan(){
        return $this->hasOne('App\Models\Tabungan','id','tabungan_id');
    }

    public function transaksi(){
        return $this->hasOne('App\Models\Transaksi','id','transaksi_id');
    }

    public function siswa(){
        return $this->hasOne('App\Models\Siswa','id','siswa_id');
    }

    public function tagihan(){
        return $this->hasOne('App\Models\Tagihan','id','tagihan_id');
    }
}
