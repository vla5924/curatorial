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
                        {{ $post->group->name }}
                        <br />
                        <small>
                            <a href="//vk.com/wall-{{ $post->group->vk_id }}_{{ $post->vk_id }}" target="_blank">
                                {{ $post->created_at }}
                            </a>
                        </small>
                    </td>
                    <td class="small-text">
                        <p>{{ $post->text }}</p>
                        @foreach ($post->attachments as $attachment)
                            @switch($attachment->type)
                                @case('photo')
                                    <img src="{{ $attachment->meta['sm'] }}" height="60">
                                    @break
                                @case('video')
                                    <img src="{{ $attachment->meta['thumb'] }}" height="60">
                                    @break
                                @default
                                    {{ $attachment->type }}
                            @endswitch
                        @endforeach
                    </td>
                    <td>
                        {{ $post->signer ? $post->signer->name : 'Not signed' }}
                    </td>
                    @can('view points')
                    <td>
                        <input type="number" min="0" value="{{ $post->points }}" onchange="Internal.editPoints(this)" data-id="{{ $post->id }}" class="form-control">
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
let Internal = {
    editPoints: function(points) {
        points.readonly = true;

        let request = {
            _token: '{{ csrf_token() }}',
            post_id: points.dataset.id,
            points: Number(points.value),
        };

        Request.internal('{{ route('internal.posts.points') }}', request,
            function (data) {
                Utils.toast('bg-success', 2000, 'Change saved', `${Number(points.value)} points were assigned to post ${points.dataset.id}`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, 'Change not saved', data.error);
            },
            function () {
                points.readonly = false;
            }
        );
    },
};
@endsection
