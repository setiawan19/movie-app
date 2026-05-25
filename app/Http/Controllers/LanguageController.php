<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Mengubah bahasa aplikasi berdasarkan parameter locale.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        // Validasi untuk memastikan hanya bahasa 'en' atau 'id' yang diproses
        if (in_array($locale, ['en', 'id'])) {
            session()->put('locale', $locale);
        }

        // Kembalikan user ke halaman sebelumnya setelah bahasa diubah
        return redirect()->back();
    }
}