<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuApiController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $books = Buku::where(function ($q) use ($query) {
            $q->where('judul_buku', 'like', "%{$query}%")
                ->orWhere('isbn', 'like', "%{$query}%")
                ->orWhere('penulis', 'like', "%{$query}%");
        })
            ->select('id_buku', 'judul_buku', 'isbn', 'stok')
            ->limit(10)
            ->get();

        return response()->json($books);
    }
}
