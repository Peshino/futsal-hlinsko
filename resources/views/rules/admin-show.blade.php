@extends('layouts.admin')

@section('title')
@lang('messages.' . $rule->name ?? '' . '') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.' . $rule->name ?? '' . '')
            </div>

            <div class="col">
                <ul class="list-inline justify-content-end">
                    <li class="list-inline-item">
                        <a class="crud-button" href="{{ route('rules.edit', [$competition->id, $rule->id]) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <form method="POST" action="{{ route('rules.destroy', [$competition->id, $rule->id]) }}"
                            autocomplete="off">
                            @csrf
                            @method('DELETE')
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-rule-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-rule-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-rule-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-rule-delete-title">
                                                @lang('messages.really_delete')
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('messages.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <h4>
                    @lang('messages.rules')
                </h4>
                <div class="p-3">
                    <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}" class="btn btn-lg">
                        {{ $rule->name ?? '' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection