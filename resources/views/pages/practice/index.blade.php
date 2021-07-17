@extends('layouts.app')

@section('title', __('practice.practices'))

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th width="50" class="d-none d-md-table-cell"></th>
                    <th>@lang('practice.name')</th>
                    <th>@lang('practice.author')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($practices as $practice)
                <tr>
                    <td class="d-none d-md-table-cell">
                        {!! \App\Helpers\GroupHelper::imageTag($practice->group, 40) !!}
                    </td>
                    <td>
                        <b>{{ $practice->name }}</b><br />
                        <small>{{ $practice->group->name }}</small>
                    </td>
                    <td>
                        @include('components.user-link', ['user' => $practice->user]) <br />
                        <small>@lang('practice.created_at') {{ $practice->created_at }}</small>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('practice.show', $practice->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('practice.view')</span>
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('practice.edit', $practice->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('practice.edit')</span>
                        </a>
                        @if ($practice->user->id == Auth::user()->id)
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $practice->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('practice.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('practice.destroy', $practice->id) }}" id="destroy-{{ $practice->id }}" hidden>
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $practices->links('vendor.pagination.bootstrap-4') }}
@endsection
