<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
   protected $fillable = ['tanggal', 'total_barang', 'total_harga'];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    protected $casts = [
    'tanggal' => 'datetime',
];

}
