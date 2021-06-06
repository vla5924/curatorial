@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ $user->avatar }}">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                <p class="text-muted text-center">{{ Str::ucfirst($user->roles[0]->name) }} </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>@lang('users.vk_id')</b> <a class="float-right" href="//vk.com/id{{ $user->vk_id }}" target="_blank">{{ $user->vk_id }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('users.user_since')</b> <span class="float-right">{{ $user->created_at }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('users.points')</b> <span class="float-right">{{ $points }}</span>
                    </li>
                </ul>

                @if($user->id == Auth::user()->id)
                <a href="{{ route('information.index') }}" class="btn btn-primary btn-block"><b>@lang('users.edit_information')</b></a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">@lang('users.about_me')</h3>
            </div>
            <div class="card-body">

                <strong><i class="fas fa-user-friends mr-1"></i> @lang('users.groups')</strong>

                <p>
                    @foreach ($user->groups as $group)
                    <a class="badge badge-secondary" href="//vk.com/public{{ $group->vk_id }}" target="_blank">{{ $group->name }}</a>
                    @endforeach
                </p>
                
                @if ($user->education)
                <hr>
                <strong><i class="fas fa-book mr-1"></i> @lang('users.education')</strong>
                <p class="text-muted">{{ $user->education }}</p>
                @endif

                @if ($user->location)
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('users.location')</strong>
                <p class="text-muted">{{ $user->location }}</p>
                @endif

                @if ($user->notes)
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> @lang('users.notes')</strong>
                <p class="text-muted">{{ $user->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
