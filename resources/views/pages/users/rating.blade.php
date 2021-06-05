@extends('layouts.app')

@section('title', 'Rating (' . ($group ? $group->name : 'Unified') . ')')

@section('content')
<div class="card">
    <div class="card-body p-2 row">
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('users.rating.index') }}" class="btn btn-primary btn-block btn-sm">Unified</a>
        </div>
        @foreach($groups as $group)
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('users.rating.group', $group->id) }}" class="btn btn-primary btn-block btn-sm">{{ $group->name }}</a>
        </div>
        @endforeach
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <th width="100">Position</th>
                <th>Name</th>
                <th>Points</th>
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
