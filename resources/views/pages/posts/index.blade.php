@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<style>
    .attachment-tile {
        width: 90px;
        margin: 0;
    }
</style>
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
                                    <a href="{{ $attachment->meta['lg'] }}" target="_blank">
                                        <img src="{{ $attachment->meta['sm'] }}" height="60">
                                    </a>
                                    @break
                                @case('video')
                                    <a href="//vk.com/video{{ $attachment->vk_owner_id }}_{{ $attachment->vk_id }}" target="_blank">
                                        <img src="{{ $attachment->meta['thumb'] }}" height="60">
                                    </a>
                                    @break
                                @case('audio')
                                    <button class="btn btn-app bg-warning text-truncate attachment-tile">
                                        <i class="fas fa-music"></i>
                                        {{ $attachment->meta['title'] }} &mdash; {{ $attachment->meta['artist'] }}
                                    </button>
                                    @break
                                @case('poll')
                                    <a class="btn btn-app bg-success text-truncate attachment-tile" href="//vk.com/poll{{ $attachment->vk_owner_id }}_{{ $attachment->vk_id }}" target="_blank">
                                        <i class="fas fa-chart-pie"></i>
                                        {{ $attachment->meta['question'] }}
                                    </a>
                                    @break
                                @case('doc')
                                    <a class="btn btn-app bg-primary text-truncate attachment-tile" href="//vk.com/doc{{ $attachment->vk_owner_id }}_{{ $attachment->vk_id }}" target="_blank">
                                        <i class="far fa-file-alt"></i>
                                        {{ $attachment->meta['title'] }}
                                    </a>
                                    @break
                                @case('link')
                                    <a class="btn btn-app bg-secondary text-truncate attachment-tile" href="{{ $attachment->meta['url'] }}" target="_blank">
                                        <i class="fas fa-link"></i>
                                        {{ $attachment->meta['title'] }}
                                    </a>
                                    @break
                                @default
                                    <button class="btn btn-app attachment-tile">
                                        <i class="fas fa-cube"></i>
                                        {{ Str::ucfirst($attachment->type) }}
                                    </button>
                            @endswitch
                        @endforeach
                    </td>
                    <td>
                        @if($post->signer)
                        @include('components.user-link', ['user' => $post->signer])
                        @else
                        (not signed)
                        @endif
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
