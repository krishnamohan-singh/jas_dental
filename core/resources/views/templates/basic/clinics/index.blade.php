@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="clinic-section py-5">
    <div class="container">
        <!-- Search Filter Row -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center">

                    <!-- Static Bengaluru Box -->
                    <div class="flex-grow-1">
                        <div class="form-control location-static">
                            Bengaluru
                        </div>
                    </div>

                    <!-- Select2 Dropdown -->
                   <div class="flex-grow-1">
                        <form action="{{ route('clinics.index') }}" method="GET" class="w-100">
                            <select class="form-select form-control local-area-select select2" name="location" onchange="this.form.submit()">
                                <option value="" {{ request('location') == '' ? 'selected' : '' }}>All</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Clear Filter Button -->
                    @if(request('location'))
                        <div>
                            <a href="{{ route('clinics.index') }}" class="btn btn-clear-filter">
                                @lang('All')
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Clinics List -->
        <div class="row g-4">
            <div class="row g-4">
                @forelse ($clinics as $clinic)
                    <div class="col-lg-6 col-md-12">
                        <div class="card shadow-sm clinic-card border-0 rounded-4 h-100 overflow-hidden">
                            <div class="row g-0 h-100">
                                <!-- Clinic Image -->
                                <div class="col-md-4">
                                    @if ($clinic->photo)
                                        <img src="{{ getImage(getFilePath('clinic') . '/' . $clinic->photo, getFileSize('clinic')) }}" class="img-fluid h-100 object-fit-cover rounded-start">
                                    @else
                                        <img src="{{ asset('assets/images/default-clinic.jpg') }}"
                                            alt="Default Clinic"
                                            class="img-fluid h-100 object-fit-cover rounded-start">
                                    @endif
                                </div>

                                <!-- Clinic Content -->
                                <div class="col-md-8 d-flex flex-column p-3">
                                    <div>
                                        <h3 class="fw-bold text-location mb-2">{{ $clinic->name }}</h3>
                                        <p class="text-muted mb-2">{{ $clinic->address }}</p>

                                        @if ($clinic->phone)
                                            <p class="mb-1">
                                                <strong>Call:</strong>
                                                <a href="tel:{{ $clinic->phone }}" class="text-decoration-none text-dark">
                                                    {{ $clinic->phone }}
                                                </a>
                                            </p>
                                        @endif

                                        @if ($clinic->email)
                                            <p class="mb-1">
                                                <strong>Email:</strong>
                                                <a href="mailto:{{ $clinic->email }}" class="text-decoration-none text-dark">
                                                    {{ $clinic->email }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-auto pt-3">
                                        <a href="{{ route('clinics.show', $clinic->id) }}" class="btn btn-book-appointment">
                                            Book Appointment <i class="las la-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-warning rounded shadow-sm" role="alert">
                            @lang('No clinics found for the selected location.')
                        </div>
                    </div>
                @endforelse
        </div>


        </div>


        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $clinics->links() }}
        </div>
    </div>
</section>

<!-- Dynamic Sections -->
@if ($sections->secs != null)
    @foreach (json_decode($sections->secs) as $sec)
        @include($activeTemplate . 'sections.' . $sec)
    @endforeach
@endif
@endsection

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .btn-clear-filter {
        background-color: #0f962d;
        color: #fff;
        border: 1px solid #0f962d;
        padding: 0.4rem 1.2rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-clear-filter:hover {
        background-color: #0f962d;
        border-color: #0f962d;
        color: #fff;
    }
    .text-location {
        color: #0f962d;
    }

    .bg-location {
        background-color: #0f962d;
        color: #fff;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        border-radius: 1rem;
    }

    .clinic-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .clinic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .view-btn {
        background-color: transparent;
        color: #0f962d;
        border: 2px solid #0f962d;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .view-btn:hover {
        background-color: #0f962d;
        color: #fff;
    }

    .location-static {
        background-color: white;
        color: #456;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding-left: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .local-area-select {
        height: 48px;
        padding-left: 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: #456;
    }

    /* Select2 Custom Styling */
    .select2-container--default .select2-selection--single {
        height: 48px !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
        padding-left: 15px;
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }

    .select2-selection__rendered {
        line-height: 46px !important;
        color: #456 !important;
    }

    .select2-selection__arrow {
        top: 10px !important;
    }


    .btn-book-appointment {
        background-color: transparent;
        color: #0f962d;
        border: 2px solid #0f962d;
        border-radius: 50px;
        padding: 0.4rem 1.2rem;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-book-appointment:hover {
        background-color: #0f962d;
        color: #fff;
    }

    .btn-book-appointment i {
        transition: transform 0.3s ease;
    }

    .btn-book-appointment:hover i {
        transform: translateX(4px);
    }


</style>
@endpush

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select a location",
            width: '100%',
            allowClear: false
        });
    });
</script>
@endpush
