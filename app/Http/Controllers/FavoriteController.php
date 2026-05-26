<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    /**
     * Menampilkan daftar film favorit yang tersimpan di session.
     */
    public function index(): View
    {
        $favorites = Session::get('favorites', []);

        return view('movies.favorites', compact('favorites'));
    }

    /**
     * Menambahkan film ke dalam daftar favorit di session.
     */
    public function add(Request $request): JsonResponse|RedirectResponse
    {
        // Validasi input untuk memastikan integritas data session
        $request->validate([
            'imdbID' => 'required|string',
            'Title'  => 'required|string',
            'Year'   => 'required',
            'Poster' => 'nullable|string',
        ]);

        $favorites = Session::get('favorites', []);
        $movieId = $request->input('imdbID');
        
        if (!isset($favorites[$movieId])) {
            $favorites[$movieId] = $request->only(['imdbID', 'Title', 'Year', 'Poster']);
            Session::put('favorites', $favorites);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success', 
                'message' => __('messages.add_to_favorite')
            ]);
        }

        return back()->with('success', __('messages.add_to_favorite'));
    }

    /**
     * Menghapus film dari daftar favorit.
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $favorites = Session::get('favorites', []);

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            Session::put('favorites', $favorites);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success', 
                'message' => __('messages.remove_favorite')
            ]);
        }

        return back()->with('success', __('messages.remove_favorite'));
    }
}