@extends('layouts.app')

@section('title', __('pollbunches.pollbunch') . ' ' . $pollbunch->id)

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="row">
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('pollbunches.author')</span>
                <span class="info-box-number text-center text-muted mb-0">
                    @include('components.user-link', ['user' => $pollbunch->user])
                </span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('pollbunches.group')</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $pollbunch->group->name }}</span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('pollbunches.created_at')</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $pollbunch->created_at }}</span>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">@lang('pollbunches.order')</th>
                    <th>@lang('pollbunches.question')</th>
                    <th>@lang('pollbunches.answers')</th>
                </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach ($pollbunch->questions as $question)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            @if ($question->multiple)
                                <i class="fas fa-check-double"></i>
                            @endif
                            {{ $question->text }}
                        </td>
                        <td>
                            @foreach ($question->answers as $answer)
                            {{ $answer->text }}
                            @if ($answer->correct)
                                <i class="fas fa-check"></i>
                            @endif
                            <br>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $pollbunch->name }}</h3>
        <div class="mt-3 mb-5">
            <a class="btn btn-primary btn-sm" href="{{ route('pollbunches.publish', $pollbunch->id) }}">
                <i class="fab fa-vk"></i> @lang('pollbunches.publish')
            </a>
            <button class="btn btn-secondary btn-sm" onclick="Internal.publishAnswers(this)">
                <i class="fas fa-comment-dots"></i> @lang('pollbunches.publish_answers')
            </button>
            <a class="btn btn-info btn-sm" href="{{ route('pollbunches.edit', $pollbunch->id) }}">
                <i class="fas fa-pencil-alt"></i> @lang('pollbunches.edit')
            </a>
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $pollbunch->id }}">
                    <i class="fas fa-trash"></i> @lang('pollbunches.delete')
            </button>
            <form method="POST" action="{{ route('pollbunches.destroy', $pollbunch->id) }}" id="destroy-{{ $pollbunch->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
        </div>

        <div class="text-muted">
        <p class="text-sm">@lang('pollbunches.unique_identifier')
            <b class="d-block">{{ $pollbunch->id }}</b>
        </p>
        <p class="text-sm">@lang('pollbunches.questions_count')
            <b class="d-block">{{ count($pollbunch->questions) }}</b>
        </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection

@section('inline-script')
let Internal = {
    publishAnswers: function (buttonElem) {
        if (!confirm())
            return false;

        let button = new LoadingButton(buttonElem, '@lang('pollbunches.publishing')');
        button.loading();

        let request = {
            _token: '{{ csrf_token() }}',
        };

        Request.internal('{{ route('internal.pollbunches.publish-answers', $pollbunch->id) }}', request,
            function (data) {
                let body = '';
                for (let i = 0; i < data.posts.length; i++)
                    body += `<i class="fas fa-check fa-fw"></i> #${i}: @lang('pollbunches.comment_created') <a href="//vk.com/wall${data.posts[i].post_id}?reply=${data.posts[i].comment_id}" target="_blank" class="fas fa-eye"></a><br />`;
                Utils.toast('bg-success', 0, '@lang('pollbunches.answers_published')', body);
            },
            function (data) {
                let body = '@lang('pollbunches.api_error')';
                if (data.error) {
                    body = data.error;
                } else if (data.posts) {
                    body = '';
                    for (let i = 0; i < data.posts.length; i++) {
                        if (data.posts[i].ok)
                            body += `<i class="fas fa-check fa-fw"></i> #${i}: @lang('pollbunches.comment_created') <a href="//vk.com/wall${data.posts[i].post_id}?reply=${data.posts[i].comment_id}" target="_blank" class="fas fa-eye"></a><br />`;
                        else
                            body += `<i class="fas fa-times fa-fw"></i> #${i}: ${data.posts[i].error}<br />`;
                    }
                }
                Utils.toast('bg-danger', 0, '@lang('pollbunches.answers_not_published')', body);
            },
            function () {
                button.ready();
            }
        );
    }
};
@endsection
