@extends('layouts.app')

@section('title', 'Assign groups')

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
                        <input type="checkbox" onclick="Internal.assignGroup(this, {{ $user->id }}, {{ $group->id }})"
                        @if($user->groups()->find($group->id)))
                            checked
                        @endif
                        />
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
    assignGroup: function (checkbox, userId, groupId) {
        let prevState = !checkbox.checked;
        checkbox.disabled = true;

        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
            group_id: groupId,
            assign: Number(checkbox.checked),
        };

        Request.internal('{{ route('internal.groups.assign') }}', request,
            function (data) {
                let part = data.assign ? 'assigned to' : 'unassigned from';
                Utils.toast('bg-success', 2000, 'Change saved', `Group ${groupId} ${part} user ${userId} successfully.`);
            },
            function (data) {
                checkbox.checked = prevState;
                Utils.toast('bg-danger', 5000, 'Change not saved', 'API error<br>' + data.error);
            },
            function () {
                checkbox.disabled = false;
            }
        );
    },
};
@endsection
