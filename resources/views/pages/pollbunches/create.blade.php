@extends('layouts.app')

@section('title', 'Create pollbunch')

@section('content')
@include('components.form-alert')

<div class="card card-primary">

    <form method="POST" enctype="multipart/form-data" action="{{ route('pollbunches.store') }}" id="pollbunch-form">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Pollbunch name briefly describing its theme" required>
            </div>
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups')
                </select>
            </div>
            <div class="form-group">
                <label>Questions</label>
                <div id="pollbunch-questions">
                </div>
                <div class="my-4">
                    <button class="btn btn-block btn-primary" onclick="internal.addQuestion();return false;">Add question</button>
                </div>
                <div class="callout callout-info">
                    <h5>Hint about marking</h5>
                    <p>If poll with the question should be with multiple answers able to choose, type <code>#</code> before its text.<br>
                       If one or more of the answers should be marked as correct, type <code>#</code> before those answers.</p>
                    <p class="mb-1"><i>Example:</i></p>
                    <pre class="p-0 m-0">
#What is 2+2?
3
#4
5
I don't know
                    </pre>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
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
            <h3 class="card-title">Question</h3>

            <div class="card-tools">
                <button class="btn btn-tool" onclick="document.getElementById('pollbunch-question-${this.questionUid}').remove();return false;"><i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
                <textarea form="pollbunch-form" name="questions[]" rows="5" style="width:100%" placeholder="Enter question data here..." required></textarea>
            </div>
        </div>
        `);
    }
};
@endsection
