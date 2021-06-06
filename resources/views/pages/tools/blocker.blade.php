@extends('layouts.app')

@section('title', __('tools.blocker'))

@section('content')
@include('components.extra-token')

<div class="my-3 p-3 bg-white rounded box-shadow">
    <h4>@lang('tools.search_for_user')</h4>
    <div class="row">
        <div class="col-12 col-md-4 col-lg-6">
            @lang('tools.paste_id_or_username')<br>
            <input type="text" maxlength="50" name="uid" id="uid" placeholder="@lang('tools.url_part')" class="form-control" onchange="user_search($(this).val())">
        </div>
        <div class="col-12 col-md-8 col-lg-6" id="user-search">

        </div>
    </div>
</div>

<div class="my-3 p-3 bg-white rounded box-shadow">
    <h4>@lang('tools.ban') <span class="text-muted" id="ban-result"></span></h4>
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-12 p-1 col-sm-6 col-md-4 col-lg-2">
            <button class="btn btn-block btn-sm btn-danger btn-act btn-ban btn-ban-{{ $group->vk_id }}" onclick="ban({{ $group->vk_id }})" disabled>{{ $group->name }}</button>
        </div>
        @endforeach
    </div>
</div>

<div class="my-3 p-3 bg-white rounded box-shadow">
    <h4>@lang('tools.unban') <span class="text-muted" id="unban-result"></span></h4>
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-12 p-1 col-sm-6 col-md-4 col-lg-2">
            <button class="btn btn-block btn-sm btn-danger btn-act btn-unban btn-unban-{{ $group->vk_id }}" onclick="unban({{ $group->vk_id }})" disabled>{{ $group->name }}</button>
        </div>
        @endforeach
    </div>
</div>


<script src="https://vk.com/js/api/openapi.js?169" type="text/javascript"></script>
@endsection

@section('inline-script')
VK.init({apiId: {{ config('services.vkontakte.client_id') }}});

var user_to_act;

function user_search(uid) {
    console.log('foo');
    $('#user-search').html('<div class="alert alert-light"><i class="fas fa-sync fa-spin"></i> @lang('tools.wait')</div>');
    if (uid == Number({{ Auth::user()->vk_id }})) {
        $('#user-search').html('<div class="alert alert-danger">@lang('tools.its_you')</div>');
    } else {
        VK.Api.call('users.get', {
            user_ids: uid,
            v: "5.122",
            fields: "photo_50"
        }, function(r) {
            if (r.response) {
                if (r.response[0].id == Number({{ Auth::user()->vk_id }})) {
                    $('#user-search').html('<div class="alert alert-danger">@lang('tools.its_you')</div>');
                } else {
                    $('#user-search').html('<div class="alert alert-primary"><img src="' + r.response[0].photo_50 + '" height="30" class="rounded mr-2"> ' + r.response[0].first_name + ' ' + r.response[0].last_name + ' <a href="//vk.com/id' + r.response[0].id + '" class="fab fa-vk" target="_blank"></a></div>');
                    $('.btn-act').removeAttr('disabled');
                    user_to_act = r.response[0].id;
                }
            } else {
                $('#user-search').html('<div class="alert alert-danger">@lang('tools.user_not_found')</div>');
            }
        });
    }
}

function free(state) {
    if (state == 1) $('.btn-act').removeAttr('disabled');
    else $('.btn-act').attr('disabled', true);
}

function ban(gid) {
    $('#ban-result').html('<i class="fas fa-sync fa-spin"></i>');
    $.ajax({
        type: "POST",
        url: "{{ route('internal.blocker.ban') }}",
        data: {
            _token: '{{ csrf_token() }}',
            user_id: user_to_act,
            group_id: gid
        }
    }).done(function(msg) {
        console.log(msg);
        if (msg.ok) {
            $('#ban-result').html('<b>' + $('.btn-ban-' + gid).html() + '</b>: @lang('tools.ban_completed')');
        } else {
            $('#ban-result').html('<b>' + $('.btn-ban-' + gid).html() + '</b>: @lang('tools.error') <i>' + msg.error + '</i>');
        }
    });
    free(0);
    setTimeout(free, 1000, 1);
}

function unban(gid) {
    $('#unban-result').html('<i class="fas fa-sync fa-spin"></i>');
    $.ajax({
        type: "POST",
        url: "{{ route('internal.blocker.unban') }}",
        data: {
            _token: '{{ csrf_token() }}',
            user_id: user_to_act,
            group_id: gid,
        }
    }).done(function(msg) {
        console.log(msg);
        if (msg.ok) {
            $('#unban-result').html('<b>' + $('.btn-unban-' + gid).html() + '</b>: @lang('tools.unban_completed')');
        } else {
            $('#unban-result').html('<b>' + $('.btn-unban-' + gid).html() + '</b>: @lang('tools.error') <i>' + msg.error + '</i>');
        }
    });
    free(0);
    setTimeout(free, 1000, 1);
}
@endsection
