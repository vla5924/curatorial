@extends('layouts.app')

@section('title', 'Publish practice')

@section('content')
<div class="col-12">
    <div class="card card-primary">
        @include('components.form-alert')

            <div class="card-body">
                <div class="form-group">
                    <label>Group</label>
                    <select class="form-control" style="width: 100%;" id="field-group-id" required>
                        @foreach ($groups as $group)
                            @include('components.user-groups', ['selected' => $practice->group->id])
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Main contents</label>
                    <input type="text" class="form-control" id="field-message" value="{{ $practice->name }}" placeholder="Enter main contents of post here (it should include theme and must not include hashtags)">
                </div>
                <div class="form-group">
                    <label>Hashtags</label>
                    <input type="text" class="form-control" id="field-hashtags" value="#{{ $practice->group->alias }}_p" placeholder="Enter corresponding hashtags (they will be appended to each post)">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Date and time</label>
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
                            <label>Interval (minutes)</label>
                            <input type="number" min="5" max="30" class="form-control" id="field-interval" value="5" placeholder="Enter interval value between posts publishing (in minutes)">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pictures about to plublish</label>
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
                <button type="submit" class="btn btn-primary" id="btn-publish">Publish</button>
                    <span class="custom-control custom-switch mx-4" style="display: inline-block">
                      <input type="checkbox" class="custom-control-input" checked id="field-signed">
                      <label class="custom-control-label" for="field-sign">Add signature</label>
                    </span>{{ csrf_token() }}
            </div>
    </div>
</div>
@endsection

@section('inline-script')
$(function () {
    $('#start_datetime').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'DD.MM.YYYY HH:mm',
        minDate: '{{ date('d.m.Y H:i') }}',
        defaultDate: '{{ date('d.m.Y H:i') }}',
    });

    $('#btn-publish').click(function() {
        $('#btn-publish').html('<i class="fas fa-sync fa-spin"></i> Publishing');
        $('#btn-publish').attr('disabled', true);

        let request = {
            _token: '{{ csrf_token() }}',
            group_id: $('#field-group-id').val(),
            message: $('#field-message').val(),
            hashtags: $('#field-hashtags').val(),
            publish_date: $('#field-publish-date').val(),
            interval: $('#field-interval').val(),
            signed: ($('#field-signed').val() == 'on'),
        };
        console.log(request);

        $.post('{{ route('internal.practice.publish', $practice->id) }}', request)
        .done(function (data) {
            if (data.ok) {
                let body = '';
                for (let i = 0; i < data.posts.length; i++)
                    body += `<i class="fas fa-check fa-fw"></i> #${i}: Postponed <a href="//vk.com/wall${data.posts[i].post_id}" target="_blank" class="fas fa-eye"></a><br />`;
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Practice published',
                    body: body,
                });
            } else {
                let body = 'API error';
                if (data.error) {
                    body = data.error;
                } else if (data.posts) {
                    body = '';
                    for (let i = 0; i < data.posts.length; i++) {
                        if (data.posts[i].ok)
                            body += `<i class="fas fa-check fa-fw"></i> #${i}: Postponed <a href="//vk.com/wall${data.posts[i].post_id}" target="_blank" class="fas fa-eye"></a><br />`;
                        else
                            body += `<i class="fas fa-times fa-fw"></i> #${i}: ${data.posts[i].error}<br />`;
                    }
                }
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Practice not published',
                    subtitle: 'API error',
                    body: body,
                });
            }
        })
        .fail(function (response) {
            let body = response.responseJSON.message ? response.responseJSON.message : 'Internal server error.';
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Practice not published',
                subtitle: 'Server error',
                body: body,
            });
        }).always(function () {
            $('#btn-publish').html('Publish');
            $('#btn-publish').attr('disabled', false);
        });
    });
});
@endsection
