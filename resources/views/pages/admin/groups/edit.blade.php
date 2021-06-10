@extends('layouts.app')

@section('title', __('groups.edit_group'))

@section('content')
@include('components.form-alert')

<div class="card card-info">
    <form class="form-horizontal" method="POST" action="{{ route('groups.update', $group->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $group->name }}" name="name" placeholder="@lang('groups.name_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.vk_id')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $group->vk_id }}" name="vk_id" placeholder="@lang('groups.vk_id_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.alias')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $group->alias }}" name="alias" placeholder="@lang('groups.alias_placeholder')" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.timetable_url')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $group->timetable_url }}" name="timetable_url" placeholder="@lang('groups.timetable_url_placeholder')">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('groups.confirmation_token')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $group->vk_confirmation_token }}" name="vk_confirmation_token" placeholder="@lang('groups.confirmation_token_placeholder')">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">@lang('groups.save')</button>
        </div>
    </form>
</div>
@endsection
