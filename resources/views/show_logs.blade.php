@extends('layout')
@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="text-white flex justify-center flex-wrap">
                <form method="get" action="/show/logs">
                    {{ csrf_field() }}
                    <label for="search">Rezerwowana data:
                        <input name="search" id="search" class="bg-dark text-white inpt3">
                    </label>
                    <button type="submit" class="btn btn-primary btn-search">Szukaj</button>
                </form>
                <table class="table table-dark table-bordered table-logs">
                    <thead>
                        <tr>
                            <th class="td_logs">Kiedy wykonano akcję</th>
                            <th class="td_logs">Rezerwowana data</th>
                            <th class="td_logs text-center">Wykonana akcja</th>
                            <th class="td_logs">Pole po zmianie</th>
                            <th class="td_logs">Kto dokonał zmian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($log as $record)
                            <tr>
                                <td class="column-hover">{{$record->when_edited}}</td>

                                <td class="column-hover">{{$record->which_edited}}</td>

                                <td class="column-hover text-center">{{$record->action}}</td>

                                <td class="column-hover text-center">{{$record->value}}</td>

                                <td class="column-hover">{{$record->info}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $log->links("pagination::bootstrap-4") }}
            </div>
            <div class="card-footer footer-layout text-center">
                <span>Copyright © {{$year}} Jakub Sznurkowski</span>
                <a href="/" class="text-right">Strona główna</a>
            </div>
        </div>
    </div>
@endsection
