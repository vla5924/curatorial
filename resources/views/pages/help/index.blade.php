@extends('layouts.app')

@section('title', __('help.manuals_and_faq'))

@section('content')
<div class="row">
    <div class="col-12" id="accordion">
        <div class="card card-primary card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        1. Lorem ipsum dolor sit amet
                    </h4>
                </div>
            </a>
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                </div>
            </div>
        </div>
        <div class="card card-warning card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        2. Donec pede justo
                    </h4>
                </div>
            </a>
            <div id="collapseFour" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                </div>
            </div>
        </div>
        <div class="card card-danger card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        3. Aenean leo ligula
                    </h4>
                </div>
            </a>
            <div id="collapseSeven" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
