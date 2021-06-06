@extends('layouts.app')

@section('title', 'Create practice')

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" enctype="multipart/form-data" action="{{ route('practice.store') }}">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Practice name briefly describing its theme" required>
            </div>
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups')
                </select>
            </div>
            <div class="form-group">
                <label>Pictures (up to 12 files in JPG or PNG format)</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" multiple accept="image/png, image/jpeg" name="pictures[]" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection
