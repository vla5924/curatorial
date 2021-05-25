@extends('layouts.app')

@section('title', 'Practices')

@section('content')
<div class="card">
    @include('components.form-alert')

    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Author</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($practices as $practice)
                <tr>
                    <td>
                        <a>{{ $practice->name }}</a><br />
                        <small>Created at {{ $practice->created_at }}</small>
                    </td>
                    <td>{{ $practice->group->name }}</td>
                    <td>{{ $practice->user->name }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('practice.show', $practice->id) }}">
                              <i class="fas fa-folder"></i> View
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('practice.edit', $practice->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm" href="#" form="destroy-{{ $practice->id }}" onclick="if(!confirm('Delete?')) return false;">
                                <i class="fas fa-trash"></i> Delete
                        </button>
                        <form method="POST" action="{{ route('practice.destroy', $practice->id) }}" id="destroy-{{ $practice->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $practices->links() }}
    </div>
</div>
@endsection
