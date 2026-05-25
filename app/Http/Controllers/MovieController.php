<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MovieController extends Controller {
    /**
     * API Key sebaiknya diletakkan di .env, namun untuk keperluan test 
     * diletakkan di sini agar portable.
     */
    private $apiKey = '6f525d05'; 

    /**
     * Base URL dibersihkan dari query parameter hardcoded (?i=tt3896198).
     */
    private $baseUrl = 'https://www.omdbapi.com/';

    public function index(Request $request) {
        $search = $request->input('s', ''); // Default search parameter jika kosong
        $page = $request->input('page', 1);

        // Jika request via AJAX (untuk Infinite Scroll)
        if ($request->ajax()) {
            return response()->json($this->fetchFromOmdb(['s' => $search, 'page' => $page]));
        }

        $movies = $this->fetchFromOmdb(['s' => $search, 'page' => $page]);
        return view('movies.index', compact('movies', 'search'));
    }

    public function detail($id) {
        $movie = $this->fetchFromOmdb(['i' => $id, 'plot' => 'full']);
        return view('movies.detail', compact('movie'));
    }

    private function fetchFromOmdb($params) {
        $client = new Client();
        $params['apikey'] = $this->apiKey;
        
        try {
            $response = $client->get($this->baseUrl, ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['Response' => 'False', 'Error' => $e->getMessage()];
        }
    }
}