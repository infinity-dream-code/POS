<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
{
        $totalBarang = Barang::count();
        $barang = Barang::orderBy('id', 'asc')->paginate(10);

        return view('barang.index', compact('barang', 'totalBarang'));
}
}
