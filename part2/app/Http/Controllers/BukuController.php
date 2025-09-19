<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use function PHPUnit\Framework\returnArgument;

class BukuController extends Controller
{
    public function search(Request $request)
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

        return $query->get();
    }

    public function getStats()
    {
        return [
            'five_newest' => Buku::orderBy('tgl_terbit', 'desc')->take(5)->get(),
            'total_books' => Buku::count(),
            'total_price' => Buku::sum('harga'),
            'min_price'   => Buku::min('harga'),
            'max_price'   => Buku::max('harga'),
        ];
    }

    public function index(Request $request)
    {
        $data_buku = $this->search($request);
        $stats     = $this->getStats();

        return view('buku.index', array_merge(
            $stats,
            [
                'data_buku'    => $data_buku,
                'search'       => $request->input('judul'),
                'nama_penulis' => $request->input('penulis'),
            ]
        ));
    }
}
