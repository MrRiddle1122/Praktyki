<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Show_logs extends Controller
{
    /*
     * Site with all the logs
     *
     * @queryParam search_term Getting term that was searched
     * @bodyParam javascript string Storing url of javascript path
     * @bodyParam css string Storing url of css path
     * @bodyParam year date Storing current year
     * @bodyParam query connection with database that getting records with searched term
     */
    function index(Request $request) {
        $search_term = $request->get('search');

        $javascript = Storage::url('js.js');
        $css = Storage::url('css/app.css');
        $year = date('Y');

        $query = DB::table('logs')->where('which_edited', 'LIKE', "%{$search_term}%")->orderBy('ID', 'desc')->paginate(25);

        return view('show_logs', ['css' => $css, 'javascript' => $javascript, 'log' => $query, 'year' => $year]);
    }
}
