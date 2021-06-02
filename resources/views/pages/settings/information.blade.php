@extends('layouts.app')

@section('title', 'Information')

@section('content')
@include('components.form-alert')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit profile information</h3>
    </div>
    <form method="POST" action="{{ route('information.store') }}">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>Education</label>
            <textarea class="form-control" name="education">{{ Auth::user()->education }}</textarea>
        </div>
        <div class="form-group">
            <label>Location</label>
            <textarea class="form-control" name="location">{{ Auth::user()->location }}</textarea>
        </div>
        <div class="form-group">
            <label>Notes</label>
            <textarea class="form-control" name="notes">{{ Auth::user()->notes }}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    </form>
</div>
@endsection
