@php
    $breadcrumbContent = getContent('breadcrumb.content',true);
  
@endphp

<section class="inner-banner-section bg-overlay-white banner-section bg_img" data-background="{{ frontendImage('breadcrumb', @$breadcrumbContent->data_values->image) }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="banner-content">
                    <h2 class="title">{{ __($pageTitle) }}</h2>
                    <div class="breadcrumb-area">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
