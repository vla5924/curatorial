@extends('layouts.app')

@section('title', __('practice.create_practice'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" enctype="multipart/form-data" action="{{ route('practice.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('practice.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('practice.name_placeholder')" required>
            </div>
            <div class="form-group">
                <label>@lang('practice.group')</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups')
                </select>
            </div>
            <div class="form-group">
                <label>@lang('practice.pictures')</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" multiple accept="image/png, image/jpeg" name="pictures[]" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('practice.create')</button>
        </div>
    </form>
</div>
@endsection
