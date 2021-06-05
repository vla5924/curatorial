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
                    <td>
                        @include('components.user-link', ['user' => $user])
                    </td>
                    <td>
                        <select onchange="Internal.assignRole(this, {{ $user->id }})">
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
let Internal = {
    assignRole: function(select, userId) {
        select.disabled = true;

        let roleId = select.value;
        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
            role_id: roleId,
        };
        
        Request.internal('{{ route('internal.roles.assign') }}', request,
            function (data) {
                Utils.toast('bg-success', 2000, 'Change saved', `Role ${roleId} assigned to user ${userId} successfully.`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, 'Change not saved', data.error);
            },
            function () {
                select.disabled = false;
            }
        );
    }
}; 
@endsection
