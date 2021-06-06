@extends('layouts.app')

@section('title', __('groups.assign_groups'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th rowspan="2">@lang('groups.user_name')</th>
                    <th colspan="{{ count($groups) }}">@lang('groups.groups')</th>
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
                let part = data.assign ? '@lang('groups.assigned_to')' : '@lang('groups.unassigned_from')';
                Utils.toast('bg-success', 2000, '@lang('groups.change_saved')', `@lang('groups.group') ${groupId} ${part} @lang('groups.user') ${userId} @lang('groups.successfully').`);
            },
            function (data) {
                checkbox.checked = prevState;
                Utils.toast('bg-danger', 5000, '@lang('groups.change_not_saved')', '@lang('groups.api_error')<br>' + data.error);
            },
            function () {
                checkbox.disabled = false;
            }
        );
    },
};
@endsection
