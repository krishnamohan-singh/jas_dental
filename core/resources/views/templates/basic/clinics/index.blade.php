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
                            Visit Us in Bengalore
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
                                @lang('Clear Search')
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Section with New Design -->
       <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <div class="stats-container d-flex flex-wrap align-items-center justify-content-center gap-5">
                    <!-- Happy Patients Section -->
                    <div class="stats-item d-flex flex-md-row flex-column align-items-center text-center text-md-start">
                        <!-- Profile Images -->
                        <div class="profile-images-stack me-md-3 mb-2 mb-md-0">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="profile-img img-1" alt="Patient 1">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="profile-img img-2" alt="Patient 2">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="profile-img img-3" alt="Patient 3">
                        </div>
                        <!-- Text -->
                        <div class="stats-text">
                            <h3 class="stats-number mb-0">201+</h3>
                            <p class="stats-label mb-0">Happy Patients</p>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="stats-item d-flex flex-column align-items-center text-center">
                        <h3 class="stats-number mb-1">4.70/5</h3>
                        <div class="stars-rating mb-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="stats-label mb-0">Reviews</p>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Clinics List -->
        <div class="row g-4">
            @forelse ($clinics as $clinic)
                <div class="col-lg-6 col-md-12">
                    <div class="card shadow-sm clinic-card border-0 rounded-4 h-100 overflow-hidden">
                        <div class="row g-0 h-100">
                            <!-- Clinic Image -->
                            <div class="col-md-4">
                                @if ($clinic->photo)
                                    <img src="{{ getImage(getFilePath('clinic') . '/' . $clinic->photo, getFileSize('clinic')) }}" 
                                         class="img-fluid h-100 object-fit-cover rounded-start"
                                         alt="{{ $clinic->name }}">
                                @else
                                    <img src="{{ asset('assets/images/default-clinic.jpg') }}"
                                         alt="Default Clinic"
                                         class="img-fluid h-100 object-fit-cover rounded-start">
                                @endif
                            </div>
                            
                            <!-- Clinic Content -->
                            <div class="col-md-8 d-flex flex-column">
                                <div class="card-body d-flex flex-column h-100">
                                    <!-- Clinic Name -->
                                    <div class="mb-3">
                                        <h3 class="clinic-name mb-2">
                                            <a href="{{ route('clinics.show', $clinic->id) }}" class="text-decoration-none">
                                                {{ $clinic->name }}
                                            </a>
                                        </h3>
                                        
                                        <!-- Address -->
                                        <p class="clinic-address text-muted mb-0">
                                            {{ $clinic->address }}
                                        </p>
                                    </div>

                                    <!-- Contact Details -->
                                    <div class="contact-details mb-3">
                                        @if ($clinic->phone)
                                            <div class="contact-item mb-2">
                                                <span class="contact-label">Call</span>
                                                <div class="contact-actions">
                                                    <a href="tel:{{ $clinic->phone }}" class="contact-link me-3">
                                                        {{ $clinic->phone }}
                                                    </a>
                                                   
                                                </div>
                                            </div>
                                        @endif

                                        @if ($clinic->email)
                                            <div class="contact-item mb-2">
                                                <span class="contact-label">Email</span>
                                                <div class="contact-actions">
                                                    <a href="mailto:{{ $clinic->email }}" class="contact-link">
                                                        {{ $clinic->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Bottom Row with Button and Rating -->
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <a href="{{ route('clinics.show', $clinic->id) }}" class="btn btn-book-appointment">
                                            GET APPOINTMENT <i class="las la-arrow-right ms-1"></i>
                                        </a>
                                        
                                        
                                    </div>
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
    .profile-images-stack {
        position: relative;
        width: 90px;
        height: 40px;
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #fff;
        position: absolute;
        object-fit: cover;
    }

    .img-1 { left: 0; z-index: 3; }
    .img-2 { left: 25px; z-index: 2; }
    .img-3 { left: 50px; z-index: 1; }

    .stats-number {
        font-weight: 700;
        font-size: 1.5rem;
        color: #444;
    }

    .stats-label {
        color: #666;
        font-size: 0.95rem;
    }

    .stars-rating i {
        color: #ffc107;
        font-size: 1.2rem;
    }

    @media (max-width: 576px) {
        .profile-images-stack {
            margin-bottom: 0.5rem;
        }
        .stats-item {
            flex-direction: column !important;
            align-items: center !important;
            text-align: center;
        }
    }

    

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
        background-color: #0d7a24;
        border-color: #0d7a24;
        color: #fff;
    }

    .clinic-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        background: #fff;
    }

    .clinic-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .clinic-name a {
        color: #28a745;
        font-weight: 600;
        font-size: 1.5rem;
        transition: color 0.3s ease;
    }

    .clinic-name a:hover {
        color: #28a745;
    }

    .clinic-address {
        font-size: 0.95rem;
        line-height: 1.4;
        color: #666;
    }

    .contact-details {
        font-size: 0.9rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .contact-label {
        font-weight: 600;
        color: #333;
        min-width: 50px;
    }

    .contact-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .contact-link {
        color: #28a745;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-link:hover {
        color: #28a745;
        text-decoration: underline;
    }

    .directions-link {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .directions-link:hover {
        color: #28a745;
        text-decoration: underline;
    }

    .btn-book-appointment {
        background-color: transparent;
        color: #28a745;
        border: 2px solid #28a745;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-book-appointment:hover {
        background-color: #28a745;
        color: #fff;
    }

    .btn-book-appointment i {
        transition: transform 0.3s ease;
    }

    .btn-book-appointment:hover i {
        transform: translateX(4px);
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