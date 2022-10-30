@extends('layouts.admin')

@section('title')
    {{ $season->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.season') {{ $season->name ?? '' }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="content-block">
                    <h4>
                        @lang('messages.competitions')
                    </h4>
                    @if (count($season->competitions) > 0)
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('messages.name')</th>
                                    <th scope="col">@lang('messages.status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($season->competitions as $competition)
                                    <div class="container mt-3">
                                        <tr class="clickable-row"
                                            data-url="{{ route('competitions.admin-show', $competition->id) }}">
                                            <td>
                                                {{ $competition->name ?? '' }}
                                            </td>
                                            <td>
                                                @lang('messages.' . $competition->status ?? '' . '')
                                            </td>
                                        </tr>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="p-3 text-center">
                        <a href="{{ route('competitions.create', $season->id) }}" class="btn btn-app">
                            @lang('messages.create_competition')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(() => {
            $('.clickable-row').click(function() {
                var url = $(this).data('url');

                window.location.href = url;
            });
        });
    </script>
@endsection
