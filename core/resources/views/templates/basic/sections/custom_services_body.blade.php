@php
    $bodyContent = getContent('custom_services_body.content',true);
@endphp

<link href="{{ asset('assets/global/css/style-about-us.css') }}" rel="stylesheet">
<link href="{{ asset('assets/global/css/media_about_us.css') }}" rel="stylesheet">

<!-- blog-section start -->
<section class="blog-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                
                    <p>@php echo trans($bodyContent->data_values->body) @endphp</p>
            
            </div>
        </div>
         
    </div>
</section>
<!-- blog-section end -->

