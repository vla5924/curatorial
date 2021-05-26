@extends('layouts.app')

@section('title', 'Pollbunch ' . $pollbunch->id)

@section('content')

<!-- Default box -->
<div class="card">
<div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="row">
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Author</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $pollbunch->user->name }}</span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Group</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $pollbunch->group->name }}</span>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Created at</span>
                <span class="info-box-number text-center text-muted mb-0">{{ $pollbunch->created_at }}</span>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">Order</th>
                    <th>Question</th>
                    <th>Answers</th>
                </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach ($pollbunch->questions as $question)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            @if ($question->multiple)
                                <i class="fas fa-check-double"></i>
                            @endif
                            {{ $question->text }}
                        </td>
                        <td>
                            @foreach ($question->answers as $answer)
                            {{ $answer->text }}
                            @if ($answer->correct)
                                <i class="fas fa-check"></i>
                            @endif
                            <br>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $pollbunch->name }}</h3>
        <div class="mt-3 mb-5">
            <a class="btn btn-primary btn-sm" href="{{ route('pollbunches.publish', $pollbunch->id) }}">
                <i class="fab fa-vk"></i> Publish
            </a>
            <a class="btn btn-info btn-sm" href="{{ route('pollbunches.edit', $pollbunch->id) }}">
                <i class="fas fa-pencil-alt"></i> Edit
            </a>
            <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $pollbunch->id }}">
                    <i class="fas fa-trash"></i> Delete
            </button>
            <form method="POST" action="{{ route('pollbunches.destroy', $pollbunch->id) }}" id="destroy-{{ $pollbunch->id }}" hidden>
                @csrf
                @method('DELETE')
            </form>
        </div>

        <div class="text-muted">
        <p class="text-sm">Unique identifier
            <b class="d-block">{{ $pollbunch->id }}</b>
        </p>
        <p class="text-sm">Questions count
            <b class="d-block">{{ count($pollbunch->questions) }}</b>
        </p>
        </div>
    </div>
    </div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
