@extends('layouts.app')

@section('title', 'Edit group')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            @include('components.form-alert')

            <form class="form-horizontal" method="POST" action="{{ route('groups.update', $group->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $group->name }}" name="name" placeholder="Full group name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">VK ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $group->vk_id }}" name="vk_id" placeholder="Integer number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Confirmation token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $group->vk_confirmation_token }}" name="vk_confirmation_token" placeholder="String used for VK webhooks confirmation"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Alias</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $group->alias }}" name="alias" placeholder="Short symbolic identifier"
                                required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
