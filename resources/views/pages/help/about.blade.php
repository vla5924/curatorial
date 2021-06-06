@extends('layouts.app')

@section('title', __('help.about'))

@section('content')
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fas fa-paw"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">@lang('help.curatorial_ege100')</span>
            <span class="info-box-text">@lang('help.curatorial_ege100_description')</span>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fab fa-laravel"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">@lang('help.laravel')</span>
            <span class="info-box-text">@lang('help.laravel_description')</span>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fas fa-smile"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">@lang('help.developer')</span>
            <span class="info-box-text">
                @lang('help.developer_description_1')
                <a href="{{ route('users.show', 1) }}">@lang('help.maksim_vlasov')</a>
                @lang('help.developer_description_2')
            </span>
        </div>
    </div>
</div>
@endsection
