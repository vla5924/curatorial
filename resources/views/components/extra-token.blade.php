@if(!$has_extra_token)
<div class="info-box shadow">
    <span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>
    <div class="info-box-content">
        <span class="info-box-number">You haven't saved extra token</span>
        <span class="info-box-text">
            VK extra token is not found.
            Please add it on <a href="{{ route('extra-token.index') }}" target="_blank">this page</a>
            in order to access special functionality below.
        </span>
    </div>
</div>
@endif
