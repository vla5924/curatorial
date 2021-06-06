@extends('layouts.app')

@section('title', __('points.adjust_points'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th rowspan="2">@lang('points.name')</th>
                    <th colspan="{{ count($groups) }}">@lang('points.groups')</th>
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
                Utils.toast('bg-success', 2000, '@lang('points.change_saved')', `@lang('points.adjustment_of') ${data.points} @lang('points.changed_for_group') ${groupId} @lang('points.of_user') ${userId} @lang('points.successfully').`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, '@lang('points.change_not_saved')', '@lang('points.api_error')<br>' + data.error);
            },
            function () {
                input.readonly = false;
            }
        );
    },
};
@endsection
