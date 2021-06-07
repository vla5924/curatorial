@extends('layouts.app')

@section('title', __('practice.practice') . ' ' . $practice->id)

@section('content')
@include('components.form-alert')

<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="row">
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('practice.author')</span>
                <span class="info-box-number text-center text-muted mb-0">
                    @include('components.user-link', ['user' => $practice->user])
                </span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('practice.group')</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $practice->group->name }}</span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">@lang('practice.created_at')</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $practice->created_at }}</span>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">@lang('practice.order')</th>
                    <th>@lang('practice.picture')</th>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $practice->name }}</h3>
        <div class="mt-3 mb-5">
            <a class="btn btn-primary btn-sm" href="{{ route('practice.publish', $practice->id) }}">
                <i class="fab fa-vk"></i> @lang('practice.publish')
            </a>
            <a class="btn btn-info btn-sm" href="{{ route('practice.edit', $practice->id) }}">
                <i class="fas fa-pencil-alt"></i> @lang('practice.edit')
            </a>
            <button type="submit" class="btn btn-danger btn-sm btn-delete" href="#" form="destroy-{{ $practice->id }}">
                    <i class="fas fa-trash"></i> @lang('practice.delete')
            </button>
            <form method="POST" action="{{ route('practice.destroy', $practice->id) }}" id="destroy-{{ $practice->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
        </div>

        <div class="text-muted">
        <p class="text-sm">@lang('practice.unique_identifier')
            <b class="d-block">{{ $practice->id }}</b>
        </p>
        <p class="text-sm">@lang('practice.pictures_count')
            <b class="d-block">{{ count($practice->pictures) }}</b>
        </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
