<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang(string $locale): RedirectResponse
    {
        // Validasi untuk memastikan hanya bahasa 'en' atau 'id' yang diproses
        if (in_array($locale, ['en', 'id'])) {
            Session::put('locale', $locale);
        }

        // Kembalikan user ke halaman sebelumnya setelah bahasa diubah
        return back();
    }
}