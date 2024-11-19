<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Day_plan extends Controller
{
    /*
     * Site with plan of the day
     *
     * @urlParam month required for moving between days and showing right ammount of time
     * @bodyParam interval string Storing amount of time that is used to showing time
     * @bodyParam next string Storing url of next icon
     * @bodyParam previous string Storing url of previous icon
     * @bodyParam javascript string Storing url of javascript path
     * @bodyParam css string Storing url of css path
     * @bodyParam current_day date Storing only current day
     * @bodyParam year date This variable storing only year after exploging month variable
     * @bodyParam month_num date This variable storing only number of month after exploging month variable
     * @bodyParam day date This variable storing only day after exploging month variable
     * @bodyParam day_name array Storing all names of the days in week that can be used in view
     * @bodyParam url_home date Storing year and number of month. Used as link to home site
     * @bodyParam day_array array Storing all information about name, surname and department that is used in view
     * @bodyParam start_work string Storing time when the work starts
     * @bodyParam end_work string Storing time when the work ends
     * @bodyParam js string Storing start_work but in loop
     * @bodyParam appointment It is connetion with database that can be used to get informatin
     * @bodyParam name string Storing name and surname of the visitor that is gets in the loop
     * @bodyParam departiment strin gStoring department name that is gets in the loop
     */
    public function index($month)
    {

        $next = Storage::url('/icons/next.png');
        $previous = Storage::url('/icons/previous.png');

        $interval = Config::get('config.interval');

        $javascript = Storage::url('js.js');
        $css = Storage::url('css/app.css');

        list($year, $month_num, $day) = explode('-', $month);

        $url_home = $year . '-' . $month_num;

        $current_day = date('w', strtotime($month));
        $current_date = date('Y-m-d');

        $day_name = ['', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek'];

        $url_previous = date('Y-m-d', strtotime($month . ' - 1 day'));
        $url_next = date('Y-m-d', strtotime($month . ' + 1 day'));

        $day_array = [];

        $start_work = '';
        $end_work = '';

        if ($current_day == 1) {
            $start_work = new DateTime(Config::get('config.monday.start'));
            $end_work = new DateTime(Config::get('config.monday.end'));

            $url_previous = date('Y-m-d', strtotime($month . ' - 3 day'));
            $url_next = date('Y-m-d', strtotime($month . ' + 1 day'));
        } elseif ($current_day == 2) {
            $start_work = new DateTime(Config::get('config.tuesday.start'));
            $end_work = new DateTime(Config::get('config.tuesday.end'));

        } elseif ($current_day == 3) {
            $start_work = new DateTime(Config::get('config.wednesday.start'));
            $end_work = new DateTime(Config::get('config.wednesday.end'));

        } elseif ($current_day == 4) {
            $start_work = new DateTime(Config::get('config.thursday.start'));
            $end_work = new DateTime(Config::get('config.thursday.end'));

        } elseif ($current_day == 5) {
            $start_work = new DateTime(Config::get('config.friday.start'));
            $end_work = new DateTime(Config::get('config.friday.end'));

            $url_previous = date('Y-m-d', strtotime($month . ' - 1 day'));
            $url_next = date('Y-m-d', strtotime($month . ' + 3 day'));
        }

        for ($js = $start_work; $js <= $end_work; $js->modify('+' . $interval . ' minutes')) {
            $appointment = DB::table('appointment')
                ->where('when_visit', '=', ($month . ' ' . $js->format('H:i:s')))
                ->get();

            if (!$appointment->isEmpty()) {
                $name = $appointment->first()->visitor_name;
                $department = $appointment->first()->department;
            } else {
                $name = '';
                $department = '';
            }

            array_push($day_array, array(
                'time' => $js->format('H:i'),
                'name' => $name,
                'department' => $department
                ));
        }

        return view('day_plan', ['next' => $next, 'previous' => $previous, 'url_next' => $url_next, 'url_previous' => $url_previous, 'month' => $month, 'url_home' => $url_home, 'day_name' => $day_name[$current_day], 'javascript' => $javascript, 'day' => $day, 'year' => $year, 'month_num' => $month_num, 'day_array' => $day_array, 'current_day' => $current_day, 'current_date' => $current_date, 'css' => $css]);
    }

    /*
     * @urlParam month Required for many things
     * @queryParam inp_time Time of the appointment
     * @queryParam inp_name_sur Name and surname of the visitor that has appointment
     * @queryParam inp_dep Name of the department
     * @bodyParam check connection with the database
     * @bodyParam data array Storing all the information about visitor
     * @bodyParam data_logs array Storig all the information that is used in logs
     */

    public function insert_data(Request $request, $month) {
        $inp_time = $request->input('inp_time');
        $inp_nam_sur = $request->input('inp_nam_sur');
        $inp_dep = $request->input('inp_dep');

        $check = DB::table('appointment')->where('when_visit', '=', ($month . ' ' . $inp_time))->first();

        $current_data = date('Y-m-d H:i:s');


        $data = array('when_visit' => ($month . ' ' . $inp_time), "when_added" => $current_data, "visitor_name" => $inp_nam_sur, "department" => $inp_dep);

        if($inp_nam_sur === null || $inp_dep === null) {
            DB::table('appointment')->where('when_visit', '=', ($month . ' ' . $inp_time))->delete();

            if ($inp_nam_sur === null) {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'delete', 'value' => '', 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            } else {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'delete', 'value' => $inp_nam_sur, 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            }
        }
        else if ($check !== null) {
            DB::table('appointment')->where('when_visit', '=', ($month . ' ' . $inp_time))->update($data);

            if ($inp_nam_sur === null) {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'change', 'value' => '', 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            } else {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'change', 'value' => $inp_nam_sur, 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            }
        }
        else {
            DB::table('appointment')->insert($data);

            if ($inp_nam_sur === null) {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'add', 'value' => '', 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            } else {
                $data_logs = array('when_edited' => $current_data, 'which_edited' => ($month . ' ' . $inp_time), 'action' => 'add', 'value' => $inp_nam_sur, 'info' => ('IP: ' . $request->ip()));
                DB::table('logs')->insert($data_logs);
            }
        }
        
        // if (true === false) {
        //     DB::table('appointment')->delete();
        //     DB::table('logs')->delete(); 
        // }

        return redirect('/day_plan/' . $month);
    }
}
