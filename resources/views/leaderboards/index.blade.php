@extends('layouts.master')

@section('title')
    @lang('messages.leaderboard') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.leaderboard')
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content text-center">
                <div class="content-block container">
                    @if (count($data) > 0)
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-left">@lang('messages.predictioner')</th>
                                    <th scope="col">@lang('messages.points')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    @php
                                        $key += 1;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $key ?? '' }}.
                                        </td>
                                        <td class="text-left">
                                            {{ $item['firstname'] }} {{ substr($item['lastname'], 0, 2) }}.
                                        </td>
                                        <td class="competition-color">
                                            <strong>{{ $item['points'] }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        -----
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
