@extends('layouts.app')

@section('title', __('practice.publish_practice'))

@section('content')
@include('components.extra-token')

<div class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label>@lang('practice.group')</label>
                <select class="form-control" style="width: 100%;" id="field-group-id" required>
                @include('components.user-groups', ['selected' => $practice->group->id])
                </select>
            </div>
            <div class="form-group">
                <label>@lang('practice.main_contents')</label>
                <input type="text" class="form-control" id="field-message" value="{{ $practice->name }}" placeholder="@lang('practice.main_contents_placeholder')">
            </div>
            <div class="form-group">
                <label>@lang('practice.hashtags')</label>
                <input type="text" class="form-control" id="field-hashtags" value="#{{ $practice->group->alias }}_p" placeholder="@lang('practice.hashtags_placeholder')">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>@lang('practice.datetime')</label>
                        <div class="input-group date" id="start_datetime" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="field-publish-date" data-target="#start_datetime">
                            <div class="input-group-append" data-target="#start_datetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('practice.interval')</label>
                        <input type="number" min="5" max="30" class="form-control" id="field-interval" value="5" placeholder="Enter interval value between posts publishing (in minutes)">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="field-signed" checked>
                    <label class="custom-control-label" for="field-signed">@lang('practice.add_signature')</label>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('practice.pictures_publish')</label>
                <div class="row">
                    @foreach ($practice->pictures as $picture)
                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="{{ Storage::url($picture->path) }}" style="max-width:100%">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btn-publish">@lang('practice.publish')</button>
        </div>
</div>
@endsection

@section('inline-script')
$(function () {
    Utils.timerPicker('start_datetime');

    $('#btn-publish').on('click', function() {
        button = new LoadingButton('btn-publish', '@lang('practice.publishing')');
        button.loading();

        let request = {
            _token: '{{ csrf_token() }}',
            group_id: Elem.id('field-group-id').value,
            message: Elem.id('field-message').value,
            hashtags: Elem.id('field-hashtags').value,
            publish_date: Elem.id('field-publish-date').value,
            interval: Elem.id('field-interval').value,
            signed: Number(Elem.id('field-signed').checked),
        };

        Request.internal('{{ route('internal.practice.publish', $practice->id) }}', request,
            function (data) {
                let body = '';
                for (let i = 0; i < data.posts.length; i++)
                    body += `<i class="fas fa-check fa-fw"></i> #${i}: @lang('practice.postponed') <a href="//vk.com/wall${data.posts[i].post_id}" target="_blank" class="fas fa-eye"></a><br />`;
                Utils.toast('bg-success', 0, '@lang('practice.published')', body);
            },
            function (data) {
                let body = '@lang('practice.api_error')';
                if (data.error) {
                    body = data.error;
                } else if (data.posts) {
                    body = '';
                    for (let i = 0; i < data.posts.length; i++) {
                        if (data.posts[i].ok)
                            body += `<i class="fas fa-check fa-fw"></i> #${i}: @lang('practice.postponed') <a href="//vk.com/wall${data.posts[i].post_id}" target="_blank" class="fas fa-eye"></a><br />`;
                        else
                            body += `<i class="fas fa-times fa-fw"></i> #${i}: ${data.posts[i].error}<br />`;
                    }
                }
                Utils.toast('bg-danger', 0, '@lang('practice.not_published')', body);
            },
            function () {
                button.ready();
            }
        );
    });
});
@endsection
