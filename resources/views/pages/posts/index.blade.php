@extends('layouts.app')

@section('title', __('posts.posts'))

@section('content')
<form method="GET" action="{{ route('posts.index') }}">
    <div class="card">
        <div class="card-body py-1 px-3 row">
            <div class="col-12 col-md-6 col-lg-3 p-1">
                <select class="form-control" name="creator_id">
                    <option value="0" {{ $filters['creator_id'] == 0 ? 'selected' : '' }}>@lang('posts.all_creators')</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $filters['creator_id'] == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 p-1">
                <select class="form-control" name="signer_id">
                    <option value="0" {{ $filters['signer_id'] == 0 ? 'selected' : '' }}>@lang('posts.all_signers')</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $filters['signer_id'] == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 p-1">
                <select class="form-control" name="group_id">
                    <option value="0" {{ $filters['group_id'] == 0 ? 'selected' : '' }}>@lang('posts.all_groups')</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $filters['group_id'] == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 p-1">
                <button class="btn btn-primary btn-block" type="submit">@lang('posts.search')</button>
            </div>
        </div>
    </div>
</form>

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
                        @lang('posts.meta')
                    </th>
                    <th>
                        @lang('posts.text')
                    </th>
                    <th>
                        @lang('posts.author')
                    </th>
                    @can('view points')
                    <th width="100">
                        @lang('posts.points')
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
                        @lang('posts.not_signed')
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
{{ $posts->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
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
                Utils.toast('bg-success', 2000, '@lang('posts.change_saved')', `${Number(points.value)} @lang('posts.points_were_assigned') ${points.dataset.id}`);
            },
            function (data) {
                Utils.toast('bg-danger', 5000, '@lang('posts.change_not_saved')', data.error);
            },
            function () {
                points.readonly = false;
            }
        );
    },
};
@endsection
