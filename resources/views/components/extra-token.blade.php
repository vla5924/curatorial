@if(!$has_extra_token)
<div class="info-box shadow">
    <span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>
    <div class="info-box-content">
        <span class="info-box-number">@lang('components.you_havent_saved_extra_token')</span>
        <span class="info-box-text">
            @lang('components.extra_token_description_1') <br>
            @lang('components.extra_token_description_2') <a href="{{ route('extra-token.index') }}" target="_blank">@lang('components.this_page')</a>,
            @lang('components.extra_token_description_3')
        </span>
    </div>
</div>
@endif
