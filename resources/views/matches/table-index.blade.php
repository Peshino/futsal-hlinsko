@extends('layouts.master')

@section('title')
@lang('messages.table') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.table')
            </div>
        </div>
    </div>

    <div class="card-body no-padding">
        <div class="content text-center">
            <div class="content-block">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            {{-- <th scope="col">pozice</th> --}}
                            {{-- <th scope="col">@lang('messages.team')</th> --}}
                            <th scope="col">@lang('messages.matches')</th>
                            <th scope="col">výhry</th>
                            <th scope="col">remízy</th>
                            <th scope="col">prohry</th>
                            {{-- <th scope="col">GV</th>
                            <th scope="col">GO</th>
                            <th scope="col">GR</th> --}}
                            <th scope="col">body</th>
                            {{-- <th scope="col">forma</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matches as $match)
                        <tr>
                            {{-- <td></td>
                            <td></td> --}}
                            <td>{{ array_sum($match['matches_count']) }}</td>
                            <td>{{ array_sum($match['wins']) }}</td>
                            <td>{{ array_sum($match['draws']) }}</td>
                            <td>{{ array_sum($match['losts']) }}</td>
                            {{-- <td></td>
                            <td></td>
                            <td></td> --}}
                            <td>{{ array_sum($match['points']) }}</td>
                            {{-- <td></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection