@extends('layouts.app')

@section('title', __('settings.information'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">@lang('settings.edit_profile_information')</h3>
    </div>
    <form method="POST" action="{{ route('information.store') }}">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>@lang('settings.education')</label>
            <textarea class="form-control" name="education">{{ Auth::user()->education }}</textarea>
        </div>
        <div class="form-group">
            <label>@lang('settings.location')</label>
            <textarea class="form-control" name="location">{{ Auth::user()->location }}</textarea>
        </div>
        <div class="form-group">
            <label>@lang('settings.notes')</label>
            <textarea class="form-control" name="notes">{{ Auth::user()->notes }}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('settings.update')</button>
    </div>
    </form>
</div>
@endsection
