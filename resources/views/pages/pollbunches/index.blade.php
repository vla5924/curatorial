@extends('layouts.app')

@section('title', 'Pollbunches')

@section('content')
@include('components.form-alert')

<div class="card">
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
                @foreach ($pollbunches as $pollbunch)
                <tr>
                    <td>
                        <a>{{ $pollbunch->name }}</a><br />
                        <small>Created at {{ $pollbunch->created_at }}</small>
                    </td>
                    <td>{{ $pollbunch->group->name }}</td>
                    <td>
                        @include('components.user-link', ['user' => $pollbunch->user])
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('pollbunches.show', $pollbunch->id) }}">
                              <i class="fas fa-folder"></i> View
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('pollbunches.edit', $pollbunch->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $pollbunch->id }}">
                                <i class="fas fa-trash"></i> Delete
                        </button>
                        <form method="POST" action="{{ route('pollbunches.destroy', $pollbunch->id) }}" id="destroy-{{ $pollbunch->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pollbunches->links() }}
    </div>
</div>
@endsection
