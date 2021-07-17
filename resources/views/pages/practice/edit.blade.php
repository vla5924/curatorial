@extends('layouts.app')

@section('title', __('practice.edit'))

@section('content')
@include('components.form-alert')

<div class="card card-primary">
    <form method="POST" action="{{ route('practice.update', $practice->id) }}">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label>@lang('practice.name')</label>
                <input type="text" class="form-control" value="{{ $practice->name }}" name="name" placeholder="@lang('practice.name_placeholder')" required>
            </div>
            <div class="form-group">
                <label>@lang('practice.group')</label>
                <select class="form-control" style="width: 100%;" name="group_id" required>
                    @include('components.user-groups', ['selected' => $practice->group->id])
                </select>
            </div>
            <div class="form-group">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>@lang('practice.order')</th>
                        <th>@lang('practice.picture')</th>
                        <th width=30%>@lang('practice.answer')</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @foreach ($practice->pictures as $picture)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <img src="{{ Storage::url($picture->path) }}" style="max-width:100%">
                            </td>
                            <td>
                                <input type="hidden" name="picture_ids[]" value="{{ $picture->id }}" />
                                <input type="text" class="form-control" value="{{ $picture->answer }}" name="picture_{{ $picture->id }}_answer" placeholder="@lang('practice.answer')">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">@lang('practice.save')</button>
        </div>
    </form>
</div>
@endsection
