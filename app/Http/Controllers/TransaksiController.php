<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('kasir.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $cartData = json_decode($request->input('cart_data'), true);

        if (!$cartData || count($cartData) === 0) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada transaksi yang dilakukan.');
        }

        $totalBarang = 0;
        $totalHarga = 0;

        foreach ($cartData as &$item) {
            $barang = Barang::find($item['id_barang']);

            if (!$barang) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan.');
            }

            $item['harga'] = $barang->harga;
            $item['total'] = $barang->harga * $item['jumlah'];

            $totalBarang += $item['jumlah'];
            $totalHarga += $item['total'];
        }

        $transaksi = Transaksi::create([
            'tanggal' => Carbon::now(),
            'total_barang' => $totalBarang,
            'total_harga' => $totalHarga
        ]);

        foreach ($cartData as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $item['id_barang'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah']
            ]);
        }

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function indextransaksi()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'desc')->paginate(10);
        return view('transaksi.index', compact('transaksi'));
    }

    public function ajaxDetail($id)
    {
        $details = DetailTransaksi::with('barang')
            ->where('id_transaksi', $id)
            ->get();

        return response()->json($details);
    }
}

