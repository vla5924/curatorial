@extends('layouts.app')

@section('title', __('settings.general_settings'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('settings.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('settings.application_language')</label>
                <select class="form-control" name="locale" required>
                    @foreach($locales as $locale => $name)
                    <option value="{{ $locale }}" {{ $user->locale == $locale ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('settings.save')</button>
        </div>
    </form>
</div>
@endsection
