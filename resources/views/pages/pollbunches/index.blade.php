@extends('layouts.app')

@section('title', __('pollbunches.pollbunches'))

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th width="50" class="d-none d-md-table-cell"></th>
                    <th>@lang('pollbunches.name')</th>
                    <th>@lang('pollbunches.author')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pollbunches as $pollbunch)
                <tr>
                    <td class="d-none d-md-table-cell">
                        {!! \App\Helpers\GroupHelper::imageTag($pollbunch->group, 40) !!}
                    </td>
                    <td>
                        <b>{{ $pollbunch->name }}</b><br />
                        <small>{{ $pollbunch->group->name }}</small>
                    </td>
                    <td>
                        @include('components.user-link', ['user' => $pollbunch->user]) <br />
                        <small>@lang('pollbunches.created_at') {{ $pollbunch->created_at }}</small>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('pollbunches.show', $pollbunch->id) }}">
                              <i class="fas fa-folder"></i>
                              <span class="d-none d-md-inline">@lang('pollbunches.view')</span>
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('pollbunches.edit', $pollbunch->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="d-none d-md-inline">@lang('pollbunches.edit')</span>
                        </a>
                        @if ($pollbunch->user->id == Auth::user()->id)
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $pollbunch->id }}">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-md-inline">@lang('pollbunches.delete')</span>
                        </button>
                        <form method="POST" action="{{ route('pollbunches.destroy', $pollbunch->id) }}" id="destroy-{{ $pollbunch->id }}" hidden>
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

{{ $pollbunches->links('vendor.pagination.bootstrap-4') }}
@endsection
