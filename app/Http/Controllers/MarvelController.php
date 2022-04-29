<?php

namespace App\Http\Controllers;

use App\Jobs\MarvelCrawler;
use App\Models\Character;
use App\Services\MarvelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarvelController extends Controller
{
    public function index(Request $request)
    {
        $page = request()->get('page', 1);
        $limit = request()->get('limit', 10);
        return cache()->remember('character' . $page, 10, function() use ($limit){
            return DB::table('characters')->paginate($limit);
        });
    }
}
