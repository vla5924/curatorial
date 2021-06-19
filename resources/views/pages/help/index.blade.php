@extends('layouts.app')

@section('title', __('help.manuals_and_faq'))

@section('content')
<div class="row">
    <div class="col-12" id="accordion">
        <div class="card card-primary card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        1. @lang('help.old_points_displayed')
                    </h4>
                </div>
            </a>
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                    @lang('help.old_points_displayed_answer')
                </div>
            </div>
        </div>
        <div class="card card-warning card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        2. @lang('help.old_practices_disappear')
                    </h4>
                </div>
            </a>
            <div id="collapseFour" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    @lang('help.old_practices_disappear_answer')
                </div>
            </div>
        </div>
        <div class="card card-danger card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        3. @lang('help.n_posts_unanswered_warning')
                    </h4>
                </div>
            </a>
            <div id="collapseSeven" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    @lang('help.n_posts_unanswered_warning_answer')
                    <br>
                    <ul class="my-0 pt-2 pb-0">
                        @foreach ($answer_markers as $marker)
                        <li>{{ $marker }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
