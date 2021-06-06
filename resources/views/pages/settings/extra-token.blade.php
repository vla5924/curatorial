@extends('layouts.app')

@section('title', 'Extra token')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="info-box shadow">
            @if ($has_token)
            <span class="info-box-icon bg-success"><i class="fas fa-key"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">You're all set!</span>
                <span class="info-box-text">
                    VK extra token saved in browser storage. Now you can publish practices and
                    pollbunches with just one click, as well as use some other useful tools!
                </span>
            </div>
            @else
            <span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">You haven't saved extra token</span>
                <span class="info-box-text">
                    VK extra token is not found. Create it and save on this page in order to
                    publish practices and pollbunches, as well as use some other tools. <br>
                    <a href="{{ $extra_token_link }}" target="_blank">Authorize and get extra token <i class="fas fa-external-link-alt"></i></a>
                </span>
            </div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="card card-info">

            <form class="form-horizontal" method="POST" action="{{ route('extra-token.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Extra token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="extra_token"
                                placeholder="Paste your token here" required>
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
