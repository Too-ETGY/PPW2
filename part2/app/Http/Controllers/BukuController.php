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

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:45',
            'harga' => 'required|integer',
            'tgl_terbit' => 'required|date'
        ]);

        Buku::create($validated);
        return redirect()->route('buku')->with('success', 'A new book has been added!!');
    }

    public function destroy($id){
        $buku = Buku::find($id);
        $buku->delete();

        return redirect()->route('buku');
    }

    public function edit($id)
    {
        $get_buku = Buku::find($id);
        return view('buku.edit', compact('get_buku'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'      => 'required|max:255',
            'penulis'    => 'required|max:45',
            'harga'      => 'required|integer',
            'tgl_terbit' => 'required|date'
        ]);

        $buku = Buku::findOrFail($id); 
        $buku->update($validated);

        return redirect()->route('buku.edit', $id)->with('success', 'The book has been updated successfully!');
    }
}
