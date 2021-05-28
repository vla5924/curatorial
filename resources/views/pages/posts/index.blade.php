@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        Meta
                    </th>
                    <th>
                        Text
                    </th>
                    <th>
                        Author
                    </th>
                    @can('view points')
                    <th width="100">
                        Points
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>
                        <a>
                            {{ $post->group->name }}
                        </a>
                        <br />
                        <small>
                            {{ $post->created_at }}
                        </small>
                    </td>
                    <td class="small-text">
                        {{ $post->text }}
                        @foreach ($post->attachments as $attachment)
                        {{ $attachment->type }}
                        @endforeach
                    </td>
                    <td>
                        {{ $post->signer ? $post->signer->name : 'Not signed' }}
                    </td>
                    @can('view points')
                    <td>
                        <input type="number" min="0" value="{{ $post->points }}" onchange="internal.editPoints(this)" data-id="{{ $post->id }}" class="form-control">
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $posts->links('vendor.pagination.bootstrap-4') }}
@endsection

@section('inline-script')
let internal = {
    editPoints: function(points) {
        points.readonly = true;

        let request = {
            _token: '{{ csrf_token() }}',
            post_id: points.dataset.id,
            points: Number(points.value),
        };

        $.post('{{ route('internal.posts.points') }}', request)
        .done(function (data) {
            if (data.ok) {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Changes saved',
                    body: `${Number(points.value)} points were assigned to post ${points.dataset.id}`,
                    autohide: true,
                    delay: 1000,
                });
            } else {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Changes not saved',
                    subtitle: 'API error',
                    body: body,
                });
            }
        })
        .fail(function (response) {
            let body = response.responseJSON.message ? response.responseJSON.message : 'Internal server error.';
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Changes not saved',
                subtitle: 'Server error',
                body: body,
            });
        }).always(function () {
            points.readonly = false;
        });
    }
};
@endsection
