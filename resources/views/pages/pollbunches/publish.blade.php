@extends('layouts.app')

@section('title', 'Publish pollbunch')

@section('content')
<div class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" style="width: 100%;" id="field-group-id" required>
                @include('components.user-groups', ['selected' => $pollbunch->group->id])
                </select>
            </div>
            <div class="form-group">
                <label>Main contents</label>
                <input type="text" class="form-control" id="field-message" value="{{ $pollbunch->name }}" placeholder="Enter main contents of post here (it should include theme and must not include hashtags)">
            </div>
            <div class="form-group">
                <label>Hashtags</label>
                <input type="text" class="form-control" id="field-hashtags" value="#{{ $pollbunch->group->alias }}_p" placeholder="Enter corresponding hashtags (they will be appended to each post)">
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
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="field-signed" checked>
                    <label class="custom-control-label" for="field-signed">Add signature</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btn-publish">Publish</button>
        </div>
</div>
@endsection

@section('inline-script')
$(function () {
    Utils.timerPicker('start_datetime');

    $('#btn-publish').on('click', function() {
        button = new LoadingButton('btn-publish', 'Publishing');
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

        Request.internal('{{ route('internal.pollbunches.publish', $pollbunch->id) }}', request,
            function (data) {
                let body = '';
                for (let i = 0; i < data.posts.length; i++)
                    body += `<i class="fas fa-check fa-fw"></i> #${i}: Postponed <a href="//vk.com/wall${data.posts[i].post_id}" target="_blank" class="fas fa-eye"></a><br />`;
                Utils.toast('bg-success', 0, 'Pollbunch published', body);
            },
            function (data) {
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
                Utils.toast('bg-danger', 0, 'Pollbunch not published', body);
            },
            function () {
                button.ready();
            }
        );
});
@endsection
