@extends('layouts.app')

@section('title', 'Practice ' . $practice->id)

@section('content')
    @include('components.groups')

    name: {{ $practice->name }}
@endsection
