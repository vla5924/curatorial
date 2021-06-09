@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $highlights['active_users'] }}</h3>

                <p>{{ trans_choice('home.active_users', $highlights['active_users'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('users.rating.index') }}" class="small-box-footer">@lang('home.view_rating') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $highlights['posts_published'] }}</h3>

                <p>{{ trans_choice('home.posts_published', $highlights['posts_published'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <a href="{{ route('posts.index') }}" class="small-box-footer">@lang('home.view_posts') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $highlights['practices_created'] }}</h3>

                <p>{{ trans_choice('home.practices_created', $highlights['practices_created'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{ route('practice.index') }}" class="small-box-footer">@lang('home.view_practices') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $highlights['pollbunches_created'] }}</h3>

                <p>{{ trans_choice('home.pollbunches_created', $highlights['pollbunches_created'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
            <a href="{{ route('pollbunches.index') }}" class="small-box-footer">@lang('home.view_pollbunches') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-magic"></i> @lang('home.get_started')</h3>
    </div>
    <div class="card-body pt-3 pb-2 px-1">
        <a class="btn btn-app bg-primary" href="{{ route('practice.create') }}">
            <i class="fas fa-book"></i>
            @lang('home.create_practice')
        </a>
        <a class="btn btn-app bg-primary" href="{{ route('pollbunches.create') }}">
            <i class="fas fa-tasks"></i>
            @lang('home.create_pollbunch')
        </a>
        <a class="btn btn-app bg-primary" href="{{ route('tools.republisher') }}">
            <i class="fas fa-share-square"></i>
            @lang('home.republish_post')
        </a>
        <a class="btn btn-app bg-primary" href="{{ route('help.index') }}">
            <i class="fas fa-question-circle"></i>
            @lang('home.visit_help')
        </a>
    </div>
</div>
@endsection