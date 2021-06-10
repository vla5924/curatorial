@extends('layouts.app')

@section('title', __('points.adjust_points'))

@section('content')
<div class="card">
    <div class="card-body p-0 table-responsive-sm">
        <table class="table">
            <thead>
                <th>@lang('points.name')</th>
                <th>@lang('points.group')</th>
                <th>@lang('points.points')</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <?php $count = $user->groups->count() ?>
                    @if($count >= 1)
                    <?php $group = $user->groups[0] ?>
                    <tr>
                        <td rowspan="{{ $count }}">
                            @include('components.user-link', ['user' => $user])
                        </td>
                        <td>
                            {{ $group->name }}
                        </td>
                        <td>
                            <?php $adjustment = App\Helpers\UserHelper::pointsAdjustment($user, $group) ?>
                            <input class="form-control" type="number" onchange="Internal.adjust(this, {{ $user->id }}, {{ $group->id }})" value="{{ $adjustment ? $adjustment->points : 0 }}" />
                        </td>
                    </tr>
                        @if($count >= 2)
                        <tr>
                            @for ($i = 1; $i < $count; $i++)
                            <?php $group = $user->groups[$i] ?>
                            <td>
                                {{ $group->name }}
                            </td>
                            <td>
                                <?php $adjustment = App\Helpers\UserHelper::pointsAdjustment($user, $group) ?>
                                <input class="form-control" type="number" onchange="Internal.adjust(this, {{ $user->id }}, {{ $group->id }})" value="{{ $adjustment ? $adjustment->points : 0 }}" />
                            </td>
                            @endfor
                        </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $users->links() }}
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
                input.value = data.points;
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
