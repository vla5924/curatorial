@extends('layouts.app')

@section('title', 'Groups')

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>VK ID</th>
                    <th>Confirmation token</th>
                    <th>Alias</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->vk_id }}</td>
                    <td>{{ $group->vk_confirmation_token }}</td>
                    <td>{{ $group->alias }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('groups.edit', $group->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm" href="#" form="destroy-{{ $group->id }}" onclick="if(!confirm('Delete?')) return false;">
                                <i class="fas fa-trash"></i> Delete
                        </button>
                        <form method="POST" action="{{ route('groups.destroy', $group->id) }}" id="destroy-{{ $group->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
