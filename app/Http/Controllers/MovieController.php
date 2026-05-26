<?php 

namespace App\Http\Controllers;

use App\Services\OmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller 
{
    /**
     * @var OmdbService
     */
    protected $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('s', Session::get('last_search', ''));

        if ($request->has('s')) {
            Session::put('last_search', $search);
        }

        $page = $request->input('page', 1);
        $data = $this->omdbService->fetch(['s' => $search, 'page' => $page]);

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
        $movie = $this->omdbService->fetch(['i' => $id, 'plot' => 'full']);

        return view('movies.detail', compact('movie'));
    }
}