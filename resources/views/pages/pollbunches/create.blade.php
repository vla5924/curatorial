@extends('layouts.app')

@section('title', __('pollbunches.create_pollbunch'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">

    <form method="POST" enctype="multipart/form-data" action="{{ route('pollbunches.store') }}" id="pollbunch-form">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>@lang('pollbunches.name')</label>
                <input type="text" class="form-control" name="name" placeholder="@lang('pollbunches.name_placeholder')" required>
            </div>
            <div class="form-group">
                <label>@lang('pollbunches.group')</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups')
                </select>
            </div>
            <div class="form-group">
                <label>@lang('pollbunches.questions')</label>
                <div id="pollbunch-questions">
                </div>
                <div class="my-4">
                    <button class="btn btn-block btn-primary" onclick="internal.addQuestion();return false;">@lang('pollbunches.add_question')</button>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('pollbunches.create')</button>
        </div>
    </form>
</div>

<div class="callout callout-warning">
    @lang('pollbunches.hint')
</div>
@endsection

@section('inline-script')
let internal = {
    questionUid: 0,

    addQuestion: function() {
        this.questionUid++;

        $('#pollbunch-questions').append(`
        <div class="card card-outline card-primary" id="pollbunch-question-${this.questionUid}">
            <div class="card-header">
            <h3 class="card-title">@lang('pollbunches.question')</h3>

            <div class="card-tools">
                <button class="btn btn-tool" onclick="document.getElementById('pollbunch-question-${this.questionUid}').remove();return false;"><i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
                <textarea form="pollbunch-form" name="questions[]" rows="5" style="width:100%" placeholder="@lang('pollbunches.question_placeholder')" required></textarea>
            </div>
        </div>
        `);
    }
};
@endsection
