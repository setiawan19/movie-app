<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * Menampilkan daftar film favorit yang tersimpan di session.
     */
    public function index(): View
    {
        // Ambil data favorit dari session, jika belum ada set array kosong
        $favorites = session()->get('favorites', []);

        return view('movies.favorites', compact('favorites'));
    }

    /**
     * Menambahkan film ke dalam daftar favorit di session.
     */
    public function add(Request $request)
    {
        // Validasi input untuk memastikan integritas data session
        $request->validate([
            'imdbID' => 'required|string',
            'Title'  => 'required|string',
            'Year'   => 'required',
            'Poster' => 'nullable|string',
        ]);

        $favorites = session()->get('favorites', []);
        $movieId = $request->input('imdbID');
        
        if (!isset($favorites[$movieId])) {
            $favorites[$movieId] = $request->only(['imdbID', 'Title', 'Year', 'Poster']);
            session()->put('favorites', $favorites);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success', 
                'message' => trans('messages.add_to_favorite')
            ]);
        }

        return back()->with('success', trans('messages.add_to_favorite'));
    }

    /**
     * Menghapus film dari daftar favorit.
     */
    public function destroy(Request $request, string $id)
    {
        $favorites = session()->get('favorites', []);

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            session()->put('favorites', $favorites);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success', 
                'message' => trans('messages.remove_favorite')
            ]);
        }

        return back()->with('success', trans('messages.remove_favorite'));
    }
}