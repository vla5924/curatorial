@extends('layouts.app')

@section('title', __('users.rating') . ' (' . ($group ? $group->name : __('users.unified')) . ')')

@section('content')
<div class="card">
    <div class="card-body px-2 pt-2 pb-0 row">
        <div class="col-6 col-md-4 col-lg-2 pb-2">
            <a href="{{ route('users.rating.index') }}" class="btn btn-primary btn-block btn-sm">@lang('users.unified')</a>
        </div>
        @foreach($groups as $group)
        <div class="col-6 col-md-4 col-lg-2 pb-2">
            <a href="{{ route('users.rating.group', $group->id) }}" class="btn btn-primary btn-block btn-sm">{{ $group->name }}</a>
        </div>
        @endforeach
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <th width="100">@lang('users.position')</th>
                <th>@lang('users.name')</th>
                <th>@lang('users.points')</th>
            </thead>
            <tbody>
                <?php $i = 1 ?>
                @foreach ($rating as $userId => $points)
                <tr>
                    <td>
                        {{ $i++ }}
                    </td>
                    <td>
                        @include('components.user-link', ['user' => $users[$userId]])
                    </td>
                    <td>
                        {{ $points }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
