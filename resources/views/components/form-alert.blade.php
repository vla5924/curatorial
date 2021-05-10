@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5><i class="icon fas fa-check"></i> Success</h5>
    {{ session('success') }}
</div>
@endif

@if(session()->has('failure'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5><i class="icon fas fa-times-circle"></i> Failure</h5>
    {{ session()->get('failure') }}
</div>
@endif
