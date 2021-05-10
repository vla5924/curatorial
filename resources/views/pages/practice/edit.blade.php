@extends('layouts.app')

@section('title', 'Edit practice')

@section('content')
<div class="col-12">
    <div class="card card-primary">
        @include('components.form-alert')

        <form method="POST" action="{{ route('practice.update', $practice->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" value="{{ $practice->name }}" name="name" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Group</label>
                    <select class="form-control" style="width: 100%;" name="group_id" required>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ $group->id == $practice->group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
