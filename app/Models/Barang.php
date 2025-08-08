<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['kode_barang', 'nama_barang', 'harga'];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }
}
