@extends('layout')
@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap sm:justify-between">
                <a href="{{ url('/' . $url_previous) }}"><img src="{{ $previous }}" alt="poprzedni" width="50" height="50"></a>
                <h1 class="text-center text-white">{{ $month_name }} {{$year}}</h1>
                <a href="{{ url('/' . $url_next) }}"><img src="{{ $next }}" alt="następny" width="50" height="50"></a>
            </div>
            <br>
            <div class="text-white flex justify-start flex-wrap kalendarz">
                <div class="day d-header">Poniedziałek</div>
                <div class="day d-header">Wtorek</div>
                <div class="day d-header">Środa</div>
                <div class="day d-header">Czwartek</div>
                <div class="day d-header">Piątek</div>
                <div class="weekend d-header">Sobota</div>
                <div class="weekend d-header">Niedziela</div>
                @for($i = 1; $i <= $num_boxes; $i += 1)
                    @if($i >= $first_day)
                        @if($i % 7 == 0 || ($i + 1) % 7 == 0)
                            @if($i - $first_day + 1 <= $num)
                                <div class="weekend">{{ $i - $first_day + 1 }}</div>
                            @else
                                <div class="weekend"></div>
                            @endif
                        @else
                            @if($i - $first_day + 1 <= $num)
                                @if(($i - $first_day + 1) == $current_day && $month_num == $current_month)
                                    <div class="current_day"
                                         onclick="window.location='{{ url('/day_plan/' . ($month . '-' . ($i - $first_day + 1))) }}'">{{ $i - $first_day + 1 }}</div>
                                @else
                                    <div class="day"
                                         onclick="window.location='{{ url('/day_plan/' . ($month . '-' . ($i - $first_day + 1))) }}'">{{ $i - $first_day + 1 }}</div>
                                @endif
                            @else
                                <div class="day empty-div"></div>
                            @endif
                        @endif
                    @else
                        @if($i % 7 == 0 || ($i + 1) % 7 == 0)
                            <div class="weekend"></div>
                        @else
                            <div class="day"></div>
                        @endif
                    @endif
                @endfor
            </div><br>
            <div class="card-footer footer-layout text-center text-white-50">
                <span>Copyright © {{$year}} Jakub Sznurkowski</span>
                <a href="/show/logs" class="text-right">Logi</a>
            </div>
        </div>
    </div>
@endsection
