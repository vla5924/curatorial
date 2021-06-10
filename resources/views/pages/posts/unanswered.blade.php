@extends('layouts.app')

@section('title', __('posts.unanswered_posts'))

@section('content')
@include('components.form-alert')

<div class="card">
    <div class="card-body p-0" style="display: block;">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th width="50" class="d-none d-md-table-cell"></th>
                    <th width="140">@lang('posts.meta')</th>
                    <th>@lang('posts.text')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <?php $vk_post = $post->post ?>
                <tr>
                    <td class="d-none d-md-table-cell">
                        {!! \App\Helpers\GroupHelper::imageTag($vk_post->group, 40) !!}
                    </td>
                    <td>
                        {{ $vk_post->group->name }}
                        <br />
                        <small>
                            <a href="//vk.com/wall-{{ $vk_post->group->vk_id }}_{{ $vk_post->vk_id }}" target="_blank">
                                {{ $vk_post->created_at }}
                            </a>
                        </small>
                    </td>
                    <td>
                        {{ Str::limit($vk_post->text, 100) }}
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="//vk.com/wall-{{ $vk_post->group->vk_id }}_{{ $vk_post->vk_id }}" target="_blank">
                              <i class="fas fa-external-link-alt"></i>
                              <span class="d-none d-md-inline">@lang('posts.open')</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $posts->links() }}
    </div>
</div>
@endsection
