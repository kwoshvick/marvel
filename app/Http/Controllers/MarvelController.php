<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarvelController extends Controller
{
    public function index(Request $request)
    {
        $page = request()->get('page', 1);
        $limit = request()->get('limit', 18);
        $characters =  cache()->remember('character' . $page, 10, function() use ($limit){
            return DB::table('characters')->paginate($limit);
        });
//        dd($characters);
        return view('index', ['characters'=>$characters]);
    }

//    public function getCharacters(){
//
//    }
}
