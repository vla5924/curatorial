@extends('layouts.app')

@section('title', __('settings.extra_token'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="info-box shadow">
            @if ($has_token)
            <span class="info-box-icon bg-success"><i class="fas fa-key"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">@lang('settings.youre_all_set')</span>
                <span class="info-box-text">
                    @lang('settings.youre_all_set_description')
                </span>
            </div>
            @else
            <span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">@lang('settings.you_havent_saved_extra_token')</span>
                <span class="info-box-text">
                    @lang('settings.you_havent_saved_extra_token_description') <br>
                    <a href="{{ $extra_token_link }}" target="_blank">@lang('settings.authorize') <i class="fas fa-external-link-alt"></i></a>
                </span>
            </div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="card card-info">

            <form class="form-horizontal" method="POST" action="{{ route('extra-token.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">@lang('settings.extra_token')</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="extra_token"
                                placeholder="@lang('settings.extra_token_placeholder')" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">@lang('settings.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
