@extends('layouts.app')

@section('title', 'Assign roles')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th style="width: 30px">ID</th>
                    <th>Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <select onchange="internal.assignRole(this, {{ $user->id }})">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                        @if($user->hasRole($role->name))
                            selected
                        @endif
                        >{{ $role->name }}</option>
                    @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>
@endsection

@section('inline-script')
let internal = {
    assignRole: function(select, userId) {
        select.disabled = true;

        let roleId = select.value;
        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
            role_id: roleId,
        };
        console.log(request);

        $.post('{{ route('internal.roles.assign') }}', request)
        .done(function (data) {
            if (data.ok) {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Change saved',
                    body: `Role ${roleId} assigned to user ${userId} successfully.`,
                    autohide: true,
                    delay: 3000,
                });
            } else {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Change not saved',
                    subtitle: 'API error',
                    body: data.error,
                    autohide: true,
                    delay: 3000,
                });
            }
        })
        .fail(function (response) {
            let body = response.responseJSON.message ? response.responseJSON.message : 'Internal server error.';
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Change not saved',
                subtitle: 'Server error',
                body: body,
                autohide: true,
                delay: 3000,
            });
        }).always(function () {
            select.disabled = false;
        });
    }
}; 
@endsection
