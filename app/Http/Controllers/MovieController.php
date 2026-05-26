<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Gunakan Wrapper HTTP Laravel yang lebih modern
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller {
    private string $apiKey;
    private string $baseUrl = 'https://www.omdbapi.com/';

    public function __construct() {
        $this->apiKey = config('services.omdb.key', '6f525d05');
    }

    public function index(Request $request): View|JsonResponse 
    {
        $search = $request->input('s', Session::get('last_search', ''));

        if ($request->has('s')) {
            Session::put('last_search', $search);
        }

        $page = $request->input('page', 1);
        $data = $this->fetchFromOmdb(['s' => $search, 'page' => $page]);

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('movies.index', [
            'movies' => $data,
            'search' => $search
        ]);
    }

    public function detail(string $id): View 
    {
        $movie = $this->fetchFromOmdb(['i' => $id, 'plot' => 'full']);
        return view('movies.detail', compact('movie'));
    }

    private function fetchFromOmdb(array $params): array 
    {
        // Implementasi HTTP Client Laravel 11 yang lebih elegan
        return Http::get($this->baseUrl, array_merge($params, [
            'apikey' => $this->apiKey
        ]))->json() ?? ['Response' => 'False', 'Error' => 'API Connection Error'];
    }
}