<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Callendar extends Controller
{
    /*
     * Main site with callendar
     *
     * @urlParam month required for moving between months
     * @bodyParam month date This variable is storing current date
     * @bodyParam url_previous date This variable is storing url that taking user to previous month
     * @bodyParam url_next date This variable is storing url that taking user to the next month
     * @bodyParam year date This variable is storing only year after exploging month variable
     * @bodyParam month_num date This variable is storing only number of month after exploging month variable
     * @bodyParam current_day date Storing only current day
     * @bodyParam current_month date Storing only current month
     * @bodyParam dt date Storing year and month
     * @bodyParam num date Checking how many days is in current month
     * @bodyParam first_day date Storing number of the first day in the month
     * @bodyParam num_boxes int Storing number of boxes in callendar
     * @bodyParam month_name array Storing all names of the months that can be used in view
     * @bodyParam next string Storing url of next icon
     * @bodyParam previous string Storing url of previous icon
     * @bodyParam javascript string Storing url of javascript path
     * @bodyParam css string Storing url of css path
     */
    public function index($month = null){

        if ($month == null) {
            $month = date('Y-m');
        }

        $url_previous = date('Y-m', strtotime($month . ' - 1 months'));
        $url_next = date('Y-m', strtotime($month . ' + 1 months'));

        list($year, $month_num) = explode('-', $month);
        $month_num = (int)$month_num;

        $current_day = date('d');
        $current_month = date('m');

        $dt = Carbon::parse('Y m');
        $num = Carbon::parse($dt->format($month))->daysInMonth;
        $first_day = date('w', strtotime($month.'-01'));

        if($num >= 30 && ($first_day == 0 || $first_day == 6)) {
            $num_boxes = 42;
        } else {
            $num_boxes = 35;
        }

        if($first_day == 0) $first_day = 7;

        $month_name = ['', 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];

        $next = Storage::url('/icons/next.png');
        $previous = Storage::url('/icons/previous.png');

        $javascript = Storage::url('js.js');
        $css = Storage::url('css/app.css');

        return view('index', ['num_boxes' => $num_boxes, 'first_day' => $first_day, 'num' => $num, 'month_name' => $month_name[$month_num], 'next' => $next, 'previous' => $previous, 'url_next' => $url_next, 'url_previous' => $url_previous, 'year' => $year, 'month' => $month, 'javascript' => $javascript, 'current_day' => $current_day, 'month_num' => $month_num, 'current_month' => $current_month, 'css' => $css]);
    }
}
