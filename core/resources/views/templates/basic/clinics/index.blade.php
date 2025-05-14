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
                    <div class="text-center mb-4">
                        <a href="{{ route('clinics.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            @lang('All')
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Clinics List -->
        <div class="row g-4">
            @forelse ($clinics as $clinic)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-1  rounded-4 clinic-card">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-location mb-2 align-self-start">{{ __($clinic->location->name ?? 'N/A') }}</span>
                            <h5 class="card-title text-location fw-semibold">
                                <a href="{{ route('clinics.show', $clinic->id) }}" class="text-decoration-none text-location">
                                    {{ Str::limit(strip_tags($clinic->name), 50) }}
                                </a>
                            </h5>
                            <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($clinic->description ?? $clinic->name), 100) }}</p>
                            <a href="{{ route('clinics.show', $clinic->id) }}" class="btn view-btn mt-3 align-self-start">
                                @lang('View Clinic') <i class="las la-angle-double-right"></i>
                            </a>
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
    .btn-clear-filter {
    background-color: #356F85;
    color: #fff;
    border: 1px solid #356F85;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    }

    .btn-clear-filter:hover {
        background-color: #2d5c6f;
        border-color: #2d5c6f;
        color: #fff;
    }
    .text-location {
        color: #356F85;
    }

    .bg-location {
        background-color: #356F85;
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
        color: #356F85;
        border: 2px solid #356F85;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .view-btn:hover {
        background-color: #356F85;
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
