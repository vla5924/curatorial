@extends('layouts.app')

@section('title', 'Nullify points')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th style="width: 30px">ID</th>
                    <th>Name</th>
                    <th>Last nullification</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @include('components.user-link', ['user' => $user])
                    </td>
                    <td id="last-nullification-{{ $user->id }}">
                        <?php $lastNullification = $user->lastPointsNullification() ?>
                        {{ $lastNullification ? $lastNullification->created_at : 'Never' }}
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="Internal.nullify(this, {{ $user->id }})">Nullify</button>
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
    nullify: function(buttonElem, userId) {
        button = new LoadingButton(buttonElem, 'Updating');
        button.loading();

        let request = {
            _token: '{{ csrf_token() }}',
            user_id: userId,
        };
        
        Request.internal('{{ route('internal.points.nullify') }}', request,
            function (data) {
                Utils.toast('bg-success', 2000, 'Change saved', `Points of user ${userId} were nullified successfully.`);
                Elem.id(`last-nullification-${userId}`).innerHTML = data.last_nullification;
            },
            function (data) {
                Utils.toast('bg-danger', 5000, 'Change not saved', data.error);
            },
            function () {
                button.ready();
            }
        );
    }
}; 
@endsection
