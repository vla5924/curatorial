@extends('layouts.app')

@section('title', __('tools.republisher'))

@section('content')
@include('components.extra-token')

<div class="col-12">
    <div class="card card-primary">
        <div class="card-body">
            <div class="form-group republisher-step-1">
                <label>@lang('tools.post_vk_id')</label>
                <input type="text" class="form-control" id="republisher-post-vk-id"
                    placeholder="@lang('tools.example'): -10175642_3060902" required>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>@lang('tools.post_origin')</label>
                <br/>
                <div class="user-block">
                    <img class="img-circle img-bordered-sm" id="post-image">
                    <a href="#" class="username" id="post-origin"></a>
                    <span class="description" id="post-date"></span>
                </div>
                <br/><br/>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>@lang('tools.post_content')</label>
                <textarea class="form-control" rows="10" id="field-message"></textarea>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>@lang('tools.attachments')</label>
                <input type="text" class="form-control" id="field-attachments" readonly>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>@lang('tools.group')</label>
                <select class="form-control" style="width: 100%;" id="field-owner-id">
                    @foreach ($groups as $group)
                    <option value="{{ -$group['id'] }}">{{ $group['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>@lang('tools.datetime')</label>
                <div class="input-group date" id="start_datetime" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" id="field-publish-date"
                        data-target="#start_datetime">
                    <div class="input-group-append" data-target="#start_datetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="field-signed" checked>
                    <label class="custom-control-label" for="field-signed">@lang('tools.add_signature')</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" onclick="Internal.fetchPost(this)">@lang('tools.fetch_post')</button>
        </div>
    </div>
</div>

<script src="https://vk.com/js/api/openapi.js?169" type="text/javascript"></script>
@endsection

@section('inline-script')
VK.init({apiId: {{ config('services.vkontakte.client_id') }}});

let Internal = {
    convertDate: function (timestamp) {
        let date = new Date(timestamp*1000);
        let year = date.getFullYear();
        let month = "0" + (date.getMonth() + 1);
        let day = "0" + date.getDate();
        let hours = "0" + date.getHours().toString();
        let minutes = "0" + date.getMinutes().toString();
        let seconds = "0" + date.getSeconds().toString();
        return `${year}-${month.substr(-2)}-${day.substr(-2)} ${hours.substr(-2)}:${minutes.substr(-2)}:${seconds.substr(-2)}`
    },

    fetchPost: function (buttonElem) {
        button = new LoadingButton(buttonElem, '@lang('tools.fetching')', '@lang('tools.publish_post')');
        button.loading();

        let id = $('#republisher-post-vk-id').val();
        VK.Api.call('wall.getById', {
            posts: id,
            extended: 1,
            fields: "name,photo_50",
            v: "5.122"
        }, function (r) {
            if (r.response) {
                postid = id;
                posttext = r.response.items[0].text;
                postattachments = []
                r.response.items[0].attachments.forEach(function (item, i, arr) {
                    switch (item.type) {
                        case 'photo':
                            tmp = 'photo' + item.photo.owner_id + '_' + item.photo.id;
                            postattachments[postattachments.length] = tmp;
                            break;
                        case 'video':
                            tmp = 'video' + item.video.owner_id + '_' + item.video.id;
                            postattachments[postattachments.length] = tmp;
                            break;
                        case 'audio':
                            tmp = 'audio' + item.audio.owner_id + '_' + item.audio.id;
                            postattachments[postattachments.length] = tmp;
                            break;
                        case 'doc':
                            tmp = 'doc' + item.doc.owner_id + '_' + item.doc.id;
                            postattachments[postattachments.length] = tmp;
                            break;
                        case 'link':
                            if (was_link == 0) {
                                tmp = item.link.url;
                                tmp = tmp.split('m.vk.com').join('vk.com');
                                postattachments[postattachments.length] = tmp;
                                was_link = 1;
                            }
                            break;
                    }
                });
                group_info = r.response.groups[0];
                Elem.id('field-message').value = posttext;
                Elem.id('field-attachments').value = postattachments.join(',');
                Elem.id('post-image').src = group_info.photo_50;
                Elem.id('post-origin').innerHTML = group_info.name;
                Elem.id('post-origin').href = `//vk.com/wall${postid}`;
                Elem.id('post-date').innerHTML = Internal.convertDate(r.response.items[0].date);
                $('#post-origin').val(posttext);
                $('.republisher-step-1').attr('hidden', true);
                $('.republisher-step-2').attr('hidden', false);
                Utils.timerPicker('start_datetime');
                button.ready();
                buttonElem.onclick = function () {
                    Internal.publishPost(buttonElem);
                };
            } else {

            }
        });
    },

    publishPost: function (buttonElem) {
        button = new LoadingButton(buttonElem, '@lang('tools.publishing')');
        button.loading();

        let ownerId = $('#field-owner-id').val();
        let request = {
            _token: '{{ csrf_token() }}',
            owner_id: ownerId,
            publish_date: Elem.id('field-publish-date').value,
            signed: Number(Elem.id('field-signed').checked),
            message: Elem.id('field-message').value,
            attachments: Elem.id('field-attachments').innerHTML,
        };

        Request.internal('{{ route('internal.republisher.publish') }}', request,
            function (data) {
                Utils.toast('bg-success', 0, '@lang('tools.post_published')', `<a href="//vk.com/wall${ownerId}_${data.post_id}" target="_blank">@lang('tools.view')</a>`);
            },
            function (data) {
                Utils.toast('bg-danger', 0, '@lang('tools.post_not_published')', data.error);
            },
            function () {
                button.ready();
            }
        );
    }
};
@endsection
