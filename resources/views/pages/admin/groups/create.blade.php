@extends('layouts.app')

@section('title', 'Add group')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            @include('components.form-alert')

            <form class="form-horizontal" method="POST" action="{{ route('groups.store') }}">
                @csrf

                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Full group name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">VK ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="vk_id" placeholder="Integer number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Confirmation token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="vk_confirmation_token" placeholder="String used for VK webhooks confirmation"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Alias</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alias" placeholder="Short symbolic identifier"
                                required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
