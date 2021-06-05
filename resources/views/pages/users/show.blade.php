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
                        <b>Unique ID</b> <a class="float-right">{{ $user->id }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>VK ID</b> <a class="float-right" href="//vk.com/id{{ $user->vk_id }}" target="_blank">{{ $user->vk_id }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>User since</b> <a class="float-right">{{ $user->created_at }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Points</b> <a class="float-right">N/A</a>
                    </li>
                </ul>

                @if($user->id == Auth::user()->id)
                <a href="{{ route('information.index') }}" class="btn btn-primary btn-block"><b>Edit information</b></a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">About Me</h3>
            </div>
            <div class="card-body">

                <strong><i class="fas fa-user-friends mr-1"></i> Groups</strong>

                <p>
                    @foreach ($user->groups as $group)
                    <span class="badge badge-secondary">{{ $group->name }}</span>
                    @endforeach
                </p>
                
                @if ($user->education)
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Education</strong>
                <p class="text-muted">{{ $user->education }}</p>
                @endif

                @if ($user->location)
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                <p class="text-muted">{{ $user->location }}</p>
                @endif

                @if ($user->notes)
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                <p class="text-muted">{{ $user->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection