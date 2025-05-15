@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="clinic-details ptb-80">
    <div class="container">

        <!-- DOCTORS SECTION (Top) -->
        <h2 class="text-center fw-bold mb-2" style="font-size: 2rem;">
            @lang('Our Doctors')
        </h2>

        @if ($clinic->doctors->isNotEmpty())
        <div class="row justify-content-center mb-5">
            @foreach($clinic->doctors as $doctor)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                    <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id . '-' . time()), '=')) }}">
                        <div class="booking-item">
                            <div class="booking-thumb position-relative">
                                <img src="{{ getImage(getFilePath('doctorProfile') . '/' . @$doctor->image, getFileSize('doctorProfile')) }}"
                                     alt="{{ __('Doctor Image') }}">
                                @if ($doctor->featured)
                                    <span class="fav-btn"><i class="fas fa-medal"></i></span>
                                @endif
                            </div>
                            <div class="booking-content">
                                <h5 class="title">
                                    {{ __($doctor->name) }} <i class="fas fa-check-circle text-success"></i>
                                </h5>
                                <ul class="booking-list">
                                    <li>
                                        <i class="fas fa-street-view icon-colored me-2"></i>
                                        <a href="{{ route('doctors.locations', $doctor->location->id) }}">
                                            {{ __($doctor->location->name) }}
                                        </a>
                                    </li>
                                    <li>
                                        <i class="fas fa-phone icon-colored me-2"></i> {{ __($doctor->mobile) }}
                                    </li>
                                </ul>
                                <div class="booking-btn">
                                    <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id . '-' . time()), '=')) }}"
                                       class="cmn-btn w-100 text-center">
                                        @lang('Book Now')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-warning text-center">
            @lang('No doctors available for this clinic.')
        </div>
        @endif


        <!-- CLINIC INFO & MAP SECTION (Bottom) -->
        <div class="row mt-5 pt-4">
            <!-- Clinic Details - Left -->
            <div class="col-md-6 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h3 class="fw-bold mb-4">{{ $clinic->name ?? 'Clinic Name' }}</h3>

                    <p class="mb-3">
                        <i class="fas fa-map-marker-alt icon-colored me-2"></i>
                        {{ $clinic->address ?? 'No address provided' }}
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-phone icon-colored me-2"></i>
                        {{ $clinic->phone ?? 'N/A' }}
                    </p>
                    @if(!empty($clinic->email))
                    <p class="mb-3">
                        <i class="fas fa-envelope icon-colored me-2"></i>
                        {{ $clinic->email }}
                    </p>
                    @endif
                    @if(!empty($clinic->opening_hours))
                    <p class="mb-0">
                        <i class="fas fa-clock icon-colored me-2"></i>
                        {{ $clinic->opening_hours }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- Google Map - Right -->
            <div class="col-md-6 mb-4">
                <div class="bg-white rounded shadow-sm overflow-hidden h-100">
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        style="min-height: 300px; border:0;"
                        src="https://www.google.com/maps?q={{ urlencode($clinic->address ?? 'New York') }}&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('style')
<style>
    .icon-colored {
        color: #356F85;
    }

    .booking-item {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        transition: 0.3s ease;
    }

    .booking-item:hover {
        box-shadow: 0 0 10px rgba(53, 111, 133, 0.2);
        transform: translateY(-3px);
    }

    .booking-thumb img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #f0ad4e;
        color: white;
        padding: 5px;
        border-radius: 50%;
    }

    .booking-content {
        padding: 15px;
    }

    .booking-content .title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .booking-list {
        list-style: none;
        padding: 0;
        margin: 0 0 15px 0;
    }

    .booking-list li {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .booking-btn .cmn-btn {
        background-color: #356F85;
        color: white;
        border: none;
        padding: 8px 0;
        border-radius: 5px;
        display: block;
    }

    .booking-btn .cmn-btn:hover {
        background-color: #285467;
    }
</style>
@endpush
