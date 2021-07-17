@extends('layouts.app')

@section('title', __('permissions.assign_roles'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>@lang('permissions.name')</th>
                    <th>@lang('permissions.role')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
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
    </div>
</div>

{{ $users->links('vendor.pagination.bootstrap-4') }}
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
                Utils.toast('bg-success', 2000, '@lang('permissions.change_saved')', `@lang('permissions.role') ${roleId} @lang('permissions.assigned_to_user') ${userId} @lang('permissions.successfully').`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, '@lang('permissions.change_not_saved')', data.error);
            },
            function () {
                select.disabled = false;
            }
        );
    }
}; 
@endsection
