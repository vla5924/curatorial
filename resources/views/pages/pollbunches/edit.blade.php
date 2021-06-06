@extends('layouts.app')

@section('title', 'Edit pollbunch')

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('pollbunches.update', $pollbunch->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $pollbunch->name }}" name="name" placeholder="Pollbunch name briefly describing its theme" required>
            </div>
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups', ['selected' => $pollbunch->group->id])
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
