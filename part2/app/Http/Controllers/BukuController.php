<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search       = $request->input('judul');
        $nama_penulis = $request->input('penulis');

        $query = Buku::query();

        if (!empty($search)) {
            $query->where('judul', 'LIKE', '%' . $search . '%');
        }

        if (!empty($nama_penulis)) {
            $query->where('penulis', $nama_penulis);
        }

        $data_buku = $query->get();

        $five_newest = Buku::orderBy('tgl_terbit', 'desc')->take(5)->get();

        // Stats
        $total_books = Buku::count();
        $total_price = Buku::sum('harga');
        $min_price   = Buku::min('harga');
        $max_price   = Buku::max('harga');

        return view('buku.index', compact(
            'data_buku',
            'five_newest',
            'search',
            'nama_penulis',
            'total_books',
            'total_price',
            'min_price',
            'max_price'
        ));
    }

}
