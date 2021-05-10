@extends('layouts.app')

@section('title', 'Publish practice')

@section('content')
<div class="col-12">
    <div class="card card-primary">
        @include('components.form-alert')

            <div class="card-body">
                <div class="form-group">
                    <label>Group</label>
                    <select class="form-control" style="width: 100%;" name="group_id" required>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ $group->id == $practice->group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Main contents</label>
                    <input type="text" class="form-control" value="{{ $practice->name }}" placeholder="Enter main contents of post here (it should include theme and must not include hashtags)">
                </div>
                <div class="form-group">
                    <label>Hashtags</label>
                    <input type="text" class="form-control" value="#{{ $practice->group->alias }}_p" placeholder="Enter corresponding hashtags (they will be appended to each post)">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Date and time</label>
                            <div class="input-group date" id="start_datetime" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#start_datetime">
                                <div class="input-group-append" data-target="#start_datetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Interval (minutes)</label>
                            <input type="number" min="5" max="30" class="form-control" value="5" placeholder="Enter interval value between posts publishing (in minutes)">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pictures about to plublish</label>
                    <div class="row">
                        @foreach ($practice->pictures as $picture)
                            <div class="col-6 col-md-4 col-lg-3">
                                <img src="{{ Storage::url($picture->path) }}" style="max-width:100%">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Publish</button>
                    <span class="custom-control custom-switch mx-4" style="display: inline-block">
                      <input type="checkbox" class="custom-control-input" checked id="customSwitch1">
                      <label class="custom-control-label" for="customSwitch1">Add signature</label>
                    </span>
            </div>
    </div>
</div>
@endsection

@section('inline-script')
$(function () {
    $('#start_datetime').datetimepicker({
        icons: { time: 'far fa-clock' },
        format: 'DD.MM.YYYY HH:mm',
        minDate: '{{ date('d.m.Y H:i') }}',
        defaultDate: '{{ date('d.m.Y H:i') }}',
    });
});
@endsection
