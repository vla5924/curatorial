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
                    <td>{{ $user->name }}</td>
                    @foreach ($groups as $group)
                    <td>
                        <input type="checkbox" onclick="internal.assignGroup(this, {{ $user->id }}, {{ $group->id }})"
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
    </div>
</div>
@endsection

@section('inline-script')
let internal = {
    assignGroup: function(checkbox, userId, groupId) {
        let prevState = !checkbox.checked;
        checkbox.disabled = true;

        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
            group_id: groupId,
            assign: Number(checkbox.checked),
        };
        console.log(request);

        $.post('{{ route('internal.groups.assign') }}', request)
        .done(function (data) {
            if (data.ok) {
                let part = data.assign ? 'assigned to' : 'unassigned from';
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Change saved',
                    body: `Group ${groupId} ${part} user ${userId} successfully.`,
                });
            } else {
                checkbox.checked = prevState;
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Change not saved',
                    subtitle: 'API error',
                    body: data.error,
                });
            }
        })
        .fail(function (response) {
            checkbox.checked = prevState;
            let body = response.responseJSON.message ? response.responseJSON.message : 'Internal server error.';
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Change not saved',
                subtitle: 'Server error',
                body: body,
            });
        }).always(function () {
            checkbox.disabled = false;
        });
    }
}; 
@endsection
