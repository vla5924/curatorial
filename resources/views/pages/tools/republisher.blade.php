@extends('layouts.app')

@section('title', 'Republisher')

@section('content')
<div class="col-12">
    <div class="card card-primary">
        <div class="card-body">
            <div class="form-group republisher-step-1">
                <label for="exampleInputEmail1">Post VK ID</label>
                <input type="text" class="form-control" id="republisher-post-vk-id"
                    placeholder="Example: -10175642_3060902" required>
            </div>
            <div id="republisher-post-content">
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>Group</label>
                <select class="form-control" style="width: 100%;" id="field-owner-id">
                    @foreach ($groups as $group)
                    <option value="{{ -$group['id'] }}">{{ $group['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group republisher-step-2" hidden>
                <label>Date and time</label>
                <div class="input-group date" id="start_datetime" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" id="field-publish-date"
                        data-target="#start_datetime">
                    <div class="input-group-append" data-target="#start_datetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" onclick="Internal.fetchPost(this)">Fetch post</button>
        </div>
    </div>
</div>

<script src="https://vk.com/js/api/openapi.js?169" type="text/javascript"></script>
@endsection

@section('inline-script')
VK.init({apiId: {{ config('services.vkontakte.client_id') }}});

let Internal = {
    fetchPost: function (buttonElem) {
        button = new LoadingButton(buttonElem, 'Fetching', 'Publish post');
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
                postattachments = postattachments.join(',');
                group_info = r.response.groups[0];
                $('#republisher-post-content').html(`<div class="alert alert-primary">
<h3><a href="//vk.com/wall${id}" target="_blank"><img class="rounded mr-2" height="40"
    src="${group_info.photo_50}"> ${group_info.name}</a></h3><textarea class="postText"
    id="field-message" rows="10" style="width:100%"></textarea><br><input type="checkbox" id="field-signed">
    <label for="field-signed">Подпись</label>
<hr>
<p><b>Прикрепления:</b> <span id="field-attachments">${postattachments.split(',').join(', ')}</span></p>
</div>`);
                $('#field-message').val(posttext);
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
        button = new LoadingButton(buttonElem, 'Publishing');
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
                Utils.toast('bg-success', 0, 'Post published', `<a href="//vk.com/wall${ownerId}_${data.post_id}" target="_blank">View</a>`);
            },
            function (data) {
                Utils.toast('bg-danger', 0, 'Post not published', data.error);
            },
            function () {
                button.ready();
            }
        );
    }
};
@endsection
