@extends('layout')
@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="text-white flex justify-center flex-wrap flex-column">
                <div class="btn-back flex justify-center">
                    <a href="{{ url('/' . $url_home) }}" class="btn btn-secondary btn-plan">Powrót</a>
                </div>
                <div class="flex flex-column justify-center">
                    <div class="flex justify-center controls_header">
                        <a href="{{ url('/day_plan/' . $url_previous) }}"><img src="{{ $previous }}" alt="poprzedni"
                                                                               width="50" height="50"></a>
                        @if(strlen(str($day)) == 1)
                            <h3 class="h-date">{{$year . '-' . $month_num . '-0' . $day}} {{$day_name}}</h3>
                        @else
                            <h3 class="h-date">{{$month}} {{$day_name}}</h3>
                        @endif
                        <a href="{{ url('/day_plan/' . $url_next) }}"><img src="{{ $next }}" alt="następny" width="50"
                                                                           height="50"></a>
                    </div>
                    <form method="POST" class="flex justify-center" action="/day_plan/{{$month}}">
                        {{ csrf_field() }}
                        <table class="table table-dark table-bordered table-meetings">
                            <thead>
                            <tr>
                                <th class="th-names">Godzina</th>
                                <th class="th-names">Imię i nazwisko klienta</th>
                                <th class="th-names">Wydział</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($j = 0, $i = 1; $j < count($day_array); $j++, $i++)
                                <tr>
                                    <th>{{$day_array[$j]['time']}}</th>

                                    @if($month < $current_date)
                                        <td class="column-hover td_name">
                                            <span id="paragraph{{$i}}">{{$day_array[$j]['name']}}</span>
                                        </td>

                                        <td class="text-center column-hover width-10 td_name">
                                            <span id="paragraph_dep{{$i}}">{{$day_array[$j]['department']}}</span>
                                        </td>
                                    @else
                                        <td class="column-hover td_name"
                                            onclick="display_div({{$i . ',' . count($day_array) . ',"' . $day_array[$j]['name'] . '","' . $day_array[$j]['department'] . '","' . $day_array[$j]['time'] . '"'}}), display_div_name({{$i}})">
                                            <span id="paragraph{{$i}}">{{$day_array[$j]['name']}}</span>
                                        </td>

                                        <td class="text-center column-hover width-10 td_name"
                                            onclick="display_div({{$i . ',' . count($day_array) . ',"' . $day_array[$j]['name'] . '","' . $day_array[$j]['department'] . '","' . $day_array[$j]['time'] . '"'}}), display_div_dep({{$i}})">
                                            <span id="paragraph_dep{{$i}}">{{$day_array[$j]['department']}}</span>
                                        </td>
                                    @endif
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                        @if($current_day == 1)
                            <label class="dis-none">
                                <input name="inp_time" id="inp_time">
                            </label>
                            <label for="input_name_and_surname" class="label-width position-absolute dis-none" id="label1">
                                <input name="inp_nam_sur" id="input_name_and_surname" class="bg-dark inpt inpt_1 text-white" maxlength="35">
                            </label>
                            <label for="input_department" class="label-width position-absolute dis-none" id="label2">
                                <input name="inp_dep" id="input_department" class="bg-dark inpt2 inpt2_2 text-white text-center" maxlength="5">
                            </label>
                            <button type="submit" class="btn btn-primary btn-save dis-none" id="save_div">Zapisz</button>
                        @else
                            <label class="dis-none">
                                <input name="inp_time" id="inp_time">
                            </label>
                            <label for="input_name_and_surname" class="label-width position-absolute dis-none" id="label1">
                                <input name="inp_nam_sur" id="input_name_and_surname" class="bg-dark inpt text-white" maxlength="35">
                            </label>
                            <label for="input_department" class="label-width position-absolute dis-none" id="label2">
                                <input name="inp_dep" id="input_department" class="bg-dark inpt2  text-white text-center" maxlength="5">
                            </label>
                            <button type="submit" class="btn btn-primary btn-save dis-none" id="save_div">Zapisz</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer footer-layout text-center">
        <span>Copyright © {{$year}} Jakub Sznurkowski</span>
        <a href="/show/logs" class="text-right">Logi</a>
    </div>
    </div>
@endsection