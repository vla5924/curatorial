@extends('layouts.app')

@section('title', __('groups.groups'))

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th width="50"></th>
                    <th>@lang('groups.name')</th>
                    <th>@lang('groups.vk_id')</th>
                    <th>@lang('groups.alias')</th>
                    <th>@lang('groups.timetable')</th>
                    <th>@lang('groups.confirmation_token')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                <tr>
                    <td>
                        {!! \App\Helpers\GroupHelper::imageTag($group, 30) !!}
                    </td>
                    <td>
                        {{ $group->name }}
                    </td>
                    <td>{{ $group->vk_id }}</td>
                    <td>{{ $group->alias }}</td>
                    <td>
                        @if($group->timetable_url)
                        <a href="{{ $group->timetable_url }}" target="_blank">
                            @lang('groups.open') <i class="fas fa-external-link-alt"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{ $group->vk_confirmation_token }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('groups.edit', $group->id) }}">
                            <i class="fas fa-pencil-alt"></i> @lang('groups.edit')
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm" href="#" form="destroy-{{ $group->id }}" onclick="if(!confirm('Delete?')) return false;">
                                <i class="fas fa-trash"></i> @lang('groups.delete')
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
