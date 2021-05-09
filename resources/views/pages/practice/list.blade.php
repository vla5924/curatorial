@extends('layouts.main')

@section('title', 'Curatorial Practice')

@section('content')
    @include('components.groups')

    @foreach ($practices as $practice)
        <p>
            name: {{ $practice->name }} |
            <a href="{{ route('singlePractice', $practice->id) }}">more...</a> |
            <a href="{{ route('practicesByGroup', $practice->group->alias) }}">{{ $practice->group->name }}</a>
        </p>
    @endforeach

    {{ $practices->links('vendor.pagination.bootstrap-4') }}
@endsection
