@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5><i class="icon fas fa-times-circle"></i> @lang('components.failure')</h5>
    @foreach($errors->all() as $error)
    {{ $error }} <br/>
    @endforeach
</div>
@else
@if(session()->has('failure'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5><i class="icon fas fa-times-circle"></i> @lang('components.failure')</h5>
    {{ session()->get('failure') }}
</div>
@else
@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5><i class="icon fas fa-check"></i> @lang('components.success')</h5>
    {{ session('success') }}
</div>
@endif
@endif
@endif
