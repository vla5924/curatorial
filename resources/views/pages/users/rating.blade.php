@extends('layouts.app')

@section('title', 'Rating')

@section('content')
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
                        {{ $users[$userId]->name }}
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
