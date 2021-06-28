@extends('layouts.app')

@section('title', __('points.nullify_points'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>@lang('points.name')</th>
                    <th>@lang('points.last_nullification')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        @include('components.user-link', ['user' => $user])
                    </td>
                    <td id="last-nullification-{{ $user->id }}">
                        <?php $lastNullification = App\Helpers\UserHelper::lastPointsNullification($user) ?>
                        {{ $lastNullification ? $lastNullification->created_at : __('points.never') }}
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="Internal.nullify(this, {{ $user->id }})">@lang('points.nullify')</button>
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
    nullify: function(buttonElem, userId) {
        button = new LoadingButton(buttonElem, '@lang('points.updating')');
        button.loading();

        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
        };
        
        Request.internal('{{ route('internal.points.nullify') }}', request,
            function (data) {
                Utils.toast('bg-success', 2000, '@lang('points.change_saved')', `@lang('points.points_of_user') ${userId} @lang('points.were_nullified_successfully').`);
                Elem.id(`last-nullification-${userId}`).innerHTML = data.last_nullification;
            },
            function (data) {
                Utils.toast('bg-danger', 5000, '@lang('points.change_not_saved')', data.error);
            },
            function () {
                button.ready();
            }
        );
    }
}; 
@endsection
