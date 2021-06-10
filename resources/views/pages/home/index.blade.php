@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $highlights['points_earned'] }}</h3>

                <p>{{ trans_choice('home.points_earned', $highlights['points_earned'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-star-half-alt"></i>
            </div>
            <a href="{{ route('users.rating.index') }}" class="small-box-footer">@lang('home.view_rating') <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box {{ $highlights['posts_unanswered'] == 0 ? 'bg-success' : 'bg-danger' }}">
            <div class="inner">
                <h3>{{ $highlights['posts_unanswered'] }}</h3>

                <p>{{ trans_choice('home.posts_unanswered', $highlights['posts_unanswered'] % 10) }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <a href="{{ route('posts.unanswered') }}" class="small-box-footer">@lang('home.view_posts') <i
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
        <a class="btn btn-app bg-primary" href="https://youtu.be/eji444UPb6M" target="_blank">
            <i class="fab fa-youtube"></i>
            @lang('home.view_teaser')
        </a>
    </div>
</div>
@endsection
