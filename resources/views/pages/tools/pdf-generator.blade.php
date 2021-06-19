@extends('layouts.app')

@section('title', __('tools.pdf_generator'))

@section('content')
<div class="col-12">
    <form method="POST" action="{{ route('tools.pdf-generator.generate')}}" target="_blank">
        @csrf

        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <label>@lang('tools.post_vk_id')</label>
                    <input type="text" class="form-control" name="vk_post_ids"
                        placeholder="@lang('tools.example'): -10175642_3060902" required>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">@lang('tools.generate')</button>
            </div>
        </div>
    </form>
</div>
@endsection
