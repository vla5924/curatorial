@extends('layouts.main')

@section('title', 'Practice ' . $practice->id)

@section('content')
    @include('components.groups')

    name: {{ $practice->name }}
@endsection
