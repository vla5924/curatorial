@extends('layouts.app')

@section('title', __('groups.add_group'))

@section('content')
@include('components.form-alert')

<div class="card card-info">

    <form class="form-horizontal" method="POST" action="{{ route('groups.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="@lang('groups.name_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.vk_id')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="vk_id" placeholder="@lang('groups.vk_id_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.alias')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="alias" placeholder="@lang('groups.alias_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.timetable_url')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="timetable_url" placeholder="@lang('groups.timetable_url_placeholder')">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.confirmation_token')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="vk_confirmation_token" placeholder="@lang('groups.confirmation_token_placeholder')">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">@lang('groups.add')</button>
        </div>
    </form>
</div>
@endsection
