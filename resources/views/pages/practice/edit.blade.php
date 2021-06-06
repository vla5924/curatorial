@extends('layouts.app')

@section('title', 'Edit practice')

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('practice.update', $practice->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $practice->name }}" name="name" placeholder="Practice name briefly describing its theme" required>
            </div>
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups', ['selected' => $practice->group->id])
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
