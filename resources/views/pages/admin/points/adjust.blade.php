@extends('layouts.app')

@section('title', 'Adjust points')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th style="width: 30px" rowspan="2">ID</th>
                    <th rowspan="2">Name</th>
                    <th colspan="{{ count($groups) }}">Groups</th>
                </tr>
                <tr>
                    @foreach ($groups as $group)
                    <th>{{ $group->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @include('components.user-link', ['user' => $user])
                    </td>
                    @foreach ($groups as $group)
                    <td>
                        <?php $adjustment = App\Helpers\UserHelper::pointsAdjustment($user, $group) ?>
                        <input class="form-control" type="number" onchange="Internal.adjust(this, {{ $user->id }}, {{ $group->id }})" value="{{ $adjustment ? $adjustment->points : 0 }}" />
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>
@endsection

@section('inline-script')
let Internal = {
    adjust: function (input, userId, groupId) {
        input.readonly = true;

        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
            group_id: groupId,
            points: Number(input.value),
        };

        Request.internal('{{ route('internal.points.adjust') }}', request,
            function (data) {
                Utils.toast('bg-success', 2000, 'Change saved', `Adjustment of ${data.points} changed for group ${groupId} of user ${userId} successfully.`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, 'Change not saved', 'API error<br>' + data.error);
            },
            function () {
                input.readonly = false;
            }
        );
    },
};
@endsection
