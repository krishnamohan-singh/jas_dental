@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="clinic-details ptb-80">
    <div class="container">
        <div class="row">
            <!-- Left Column: Doctors List -->
            <div class="col-lg-5 order-2 order-lg-1">
                <h2 class="text-center fw-bold mb-2 py-3" style="font-size: 2rem;">
                    @lang('Meet Our Doctors')
                </h2>
               @if ($doctors->isNotEmpty())
                    <div class="row g-4">
                        @foreach($doctors as $doctor)
                            <div class="col-12">
                                <div class="border rounded shadow-sm p-3 d-flex flex-column flex-md-row align-items-start gap-3 bg-white">
                                    
                                    {{-- Doctor Image --}}
                                    <div class="position-relative" style="flex: 0 0 200px;">
                                        <img src="{{ getImage(getFilePath('doctorProfile') . '/' . @$doctor->image, getFileSize('doctorProfile')) }}"
                                            alt="{{ $doctor->name }}"
                                            class="img-fluid rounded"
                                            style="width: 200px; height: 200px; object-fit: cover;">

                                        @if ($doctor->featured)
                                            <span class="position-absolute top-0 end-0 m-2">
                                                <i class="fas fa-medal text-warning fs-5"></i>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Doctor Info --}}
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2">
                                            {{ $doctor->name }} <i class="fas fa-check-circle text-success"></i>
                                        </h4>

                                        <ul class="list-unstyled text-muted small mb-3">
                                           <li class="mb-1">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                <a href="{{ route('doctors.locations', $doctor->location->id) }}" class="text-decoration-none">
                                                    {{ $doctor->location->name }}
                                                </a>
                                            </li> 
                                             <li class="mb-1">
                                                <i class="fas fa-phone me-2 text-success"></i> {{ $doctor->mobile }}
                                            </li>
                                            <li class="mb-1">
                                                <i class="fas fa-user-md me-2 text-secondary"></i>
                                                <strong>@lang('Qualification:')</strong> {{ $doctor->qualification }}
                                            </li>
                                        </ul>

                                        {{-- Short Bio --}}
                                        <p class="mb-3">
                                            <strong>@lang('About:')</strong>
                                            {{ Str::limit(strip_tags($doctor->about), 150, '...') }}
                                        </p>

                                        {{-- Social Icons --}}
                                        @if ($doctor->socialIcons->isNotEmpty())
                                            <div class="mb-3">
                                                @foreach ($doctor->socialIcons as $social)
                                                    <a href="{{ $social->url }}" target="_blank" class="me-2 text-dark fs-5">
                                                        {!! $social->icon !!}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- View Details Button --}}
                                        <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id . '-' . time()), '=')) }}"
                                        class="btn btn-outline-primary btn-sm">
                                            @lang('View Details')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Pagination Links --}}
                        @if ($doctors->hasPages())
                            <div class="mt-4">
                                {{ $doctors->links() }}
                            </div>
                        @endif
                    </div>

                @else
                    <div class="alert alert-warning text-center">
                        @lang('No doctors available for this clinic.')
                    </div>
                @endif
            </div>

            <!-- Right Column: Schedule Booking -->
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="container-fluid">
                    <div class="overview-area mrb-40">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-item">
                                    <div class="overview-tab-content">
                                        <div class="overview-booking-header d-flex flex-wrap justify-content-between align-items-center mb-4">
                                           <div class="overview-booking-header-left">
                                                @if ($clinic->serial_day && ($clinic->serial_or_slot || $clinic->serial_or_slot1 || $clinic->serial_or_slot2))
                                                    <h4 class="title">@lang('Available Schedule')</h4>                                                            
                                                @else
                                                    <h4 class="title">@lang('No appointments here today, unfortunately.')</h4>
                                                    <h4 class="title">@lang('Let’s find you a spot at one of our other nearby clinics!')</h4>
                                                    <a href="{{ route('clinics.index') }}" class="cmn-btn mt-2 mb-4">
                                                        @lang('View Other Clinics')
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="overview-booking-header-right">
                                                <ul class="overview-booking-list">
                                                    <li class="available">@lang('Available')</li>
                                                    <li class="booked">@lang('Booked')</li>
                                                    <li class="selected">@lang('Selected')</li>
                                                </ul>
                                            </div>
                                        </div>

                                        @if ($clinic->serial_day && ($clinic->serial_or_slot || $clinic->serial_or_slot1 || $clinic->serial_or_slot2))
                                            <form action="{{ route('doctor.appointment.store', $clinic->id) }}" method="post" class="appointment-from">
                                                @csrf

                                                <div class="overview-booking-area">
                                                    <div class="overview-date-area mb-4">
                                                        <div class="overview-date-header mb-3">
                                                            <h5 class="title">@lang('Choose Your Date & Time')</h5>
                                                        </div>
                                                        
                                                        {{-- Date Selector --}}
                                                        <div class="date-selector-wrapper">
                                                            <div id="custom-date-select" class="scroll-wrapper">
                                                                @foreach ($availableDate as $date)
                                                                    @php
                                                                        $carbonDate = \Carbon\Carbon::parse($date);
                                                                        $isActive = $loop->first ? 'active' : '';
                                                                    @endphp
                                                                    <button type="button"
                                                                        class="scroll-btn date-btn {{ $isActive }}"
                                                                        data-date="{{ $date }}">
                                                                        <div class="date-day">{{ $carbonDate->format('D') }}</div>
                                                                        <div class="date-number">{{ $carbonDate->format('d') }}</div>
                                                                        <div class="date-month">{{ $carbonDate->format('M') }}</div>
                                                                    </button>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" id="timeslotedate" name="booking_date" value="{{ $availableDate[0] }}">
                                                    </div>

                                                    {{-- Time Slot Navigation --}}
                                                    <!-- Mobile Dropdown -->
                                                    <div class="d-md-none mb-3">
                                                        <select class="form-select" id="slotDropdown" onchange="handleSlotChange(this.value)">
                                                            @if ($clinic->serial_or_slot)
                                                                <option value="#morning">@lang('Morning Slot')</option>
                                                            @endif
                                                            @if ($clinic->serial_or_slot1)
                                                                <option value="#afternoon">@lang('Afternoon Slot')</option>
                                                            @endif
                                                            @if ($clinic->serial_or_slot2)
                                                                <option value="#evening">@lang('Evening Slot')</option>
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <!-- Desktop Tabs -->
                                                    <ul class="nav nav-tabs mb-3 d-none d-md-flex" id="slotTab" role="tablist">
                                                        @if ($clinic->serial_or_slot)
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active" id="morning-tab" data-bs-toggle="tab" data-bs-target="#morning" type="button" role="tab">@lang('Morning Slot')</button>
                                                            </li>
                                                        @endif
                                                        @if ($clinic->serial_or_slot1)
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link @if(!$clinic->serial_or_slot) active @endif" id="afternoon-tab" data-bs-toggle="tab" data-bs-target="#afternoon" type="button" role="tab">@lang('Afternoon Slot')</button>
                                                            </li>
                                                        @endif
                                                        @if ($clinic->serial_or_slot2)
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link @if(!$clinic->serial_or_slot && !$clinic->serial_or_slot1) active @endif" id="evening-tab" data-bs-toggle="tab" data-bs-target="#evening" type="button" role="tab">@lang('Evening Slot')</button>
                                                            </li>
                                                        @endif
                                                    </ul>

                                                    {{-- Time Slots Content --}}
                                                    <div class="tab-content" id="slotTabContent">
                                                        @if ($clinic->serial_or_slot)
                                                            <div class="tab-pane fade show active" id="morning" role="tabpanel">
                                                                <div><b>@lang('Morning Time Slot')</b></div>
                                                                <hr>
                                                                <div class="time-slot-wrapper">
                                                                    <div class="time-slot-select scroll-wrapper">
                                                                        @foreach ($clinic->serial_or_slot as $item)
                                                                            <button type="button"
                                                                                class="scroll-btn time-slot-btn available-time"
                                                                                data-value="{{ $item }}">
                                                                                {{ __($item) }}
                                                                            </button>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($clinic->serial_or_slot1)
                                                            <div class="tab-pane fade @if(!$clinic->serial_or_slot) show active @endif" id="afternoon" role="tabpanel">
                                                                <div><b>@lang('Afternoon Time Slot')</b></div>
                                                                <hr>
                                                                <div class="time-slot-wrapper">
                                                                    <div class="time-slot-select scroll-wrapper">
                                                                        @foreach ($clinic->serial_or_slot1 as $item)
                                                                            <button type="button"
                                                                                class="scroll-btn time-slot-btn available-time"
                                                                                data-value="{{ $item }}">
                                                                                {{ __($item) }}
                                                                            </button>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($clinic->serial_or_slot2)
                                                            <div class="tab-pane fade @if(!$clinic->serial_or_slot && !$clinic->serial_or_slot1) show active @endif" id="evening" role="tabpanel">
                                                                <div><b>@lang('Evening Time Slot')</b></div>
                                                                <hr>
                                                                <div class="time-slot-wrapper">
                                                                    <div class="time-slot-select scroll-wrapper">
                                                                        @foreach ($clinic->serial_or_slot2 as $item)
                                                                            <button type="button"
                                                                                class="scroll-btn time-slot-btn available-time"
                                                                                data-value="{{ $item }}">
                                                                                {{ __($item) }}
                                                                            </button>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <input type="hidden" class="time" name="time_serial" required>
                                                </div>

                                                <!-- Booking Form -->
                                                <div class="booking-appoint-area mt-4">
                                                    <div class="row justify-content-center">
                                                        <div class="col-12">
                                                            <div class="booking-appoint-form-area">
                                                                <h4 class="title">@lang('Appointment Form')</h4>
                                                                <div class="booking-appoint-form">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 form-group">
                                                                            <input type="text" name="name" class="form-control" placeholder="@lang('Enter Name')" required>
                                                                        </div>
                                                                        <div class="col-lg-6 form-group">
                                                                            <input type="number" name="age" class="form-control" placeholder="@lang('Enter Age')" required>
                                                                        </div>
                                                                        <div class="col-lg-12 form-group">
                                                                            <input type="email" name="email" class="form-control" placeholder="@lang('Enter E-mail')" required>
                                                                        </div>
                                                                        <div class="col-lg-12 form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">{{ gs('country_code') }}</span>
                                                                                <input type="number" name="mobile" class="form-control" placeholder="@lang('Enter Mobile Number')" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 form-group">
                                                                            <textarea name="disease" class="form-control" placeholder="@lang('Discribe your dentees issue')"></textarea>
                                                                        </div>
                                                                        <div class="col-lg-12 form-group d-flex flex-wrap justify-content-between gap-2">
                                                                            <button type="submit" class="cmn-btn payment-system" data-value="2">@lang('Book Now')</button>
                                                                            @if (gs('online_payment'))
                                                                               <!-- <button type="submit" class="cmn-btn payment-system" data-value="1">@lang('Pay Online')</button> -->
                                                                            @endif
                                                                            <input type="hidden" name="payment_system" class="payment" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CLINIC INFO & MAP SECTION -->
<section class="clinic-info-map">
    <div class="container">
        <div class="row">
            <!-- Clinic Details (Left) -->
            <div class="col-md-6 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h3 class="fw-bold mb-4">
                        {{ $clinic->name ?? 'Clinic Name' }}
                    </h3>

                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt icon-colored me-2 text-danger"></i>
                            {{ $clinic->address ?? 'No address provided' }}
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone icon-colored me-2 text-success"></i>
                            {{ $clinic->phone ?? 'N/A' }}
                        </li>
                        @if(!empty($clinic->email))
                        <li class="mb-3">
                            <i class="fas fa-envelope icon-colored me-2 text-primary"></i>
                            {{ $clinic->email }}
                        </li>
                        @endif
                        @if(!empty($clinic->opening_hours))
                        <li>
                            <i class="fas fa-clock icon-colored me-2 text-warning"></i>
                            {{ $clinic->opening_hours }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Google Map (Right) -->
            <div class="col-md-6 mb-4">
                <div class="bg-white rounded shadow-sm overflow-hidden h-100">
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        style="min-height: 300px; border: 0;"
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
    /* Date and Time Slot Selectors */
    .scroll-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 12px;
        padding: 10px 0;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .scroll-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .scroll-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .scroll-btn {
        flex: 0 0 auto;
        scroll-snap-align: start;
        padding: 12px 16px;
        min-width: 80px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        background-color: #ffffff;
        color: #495057;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 14px;
    }

    .scroll-btn:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Date Button Specific Styles */
    .date-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 85px;
        padding: 10px 12px;
    }

    .date-btn .date-day {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 2px;
        opacity: 0.7;
    }

    .date-btn .date-number {
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
        margin-bottom: 2px;
    }

    .date-btn .date-month {
        font-size: 11px;
        font-weight: 500;
        opacity: 0.8;
    }

    .date-btn.active {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .date-btn.active .date-day,
    .date-btn.active .date-month {
        opacity: 0.9;
    }

    /* Time Slot Button Styles */
    .time-slot-btn {
        min-width: 100px;
        padding: 10px 16px;
        font-weight: 500;
    }

    .time-slot-btn.selected {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        color: white;
        border-color: #28a745;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .time-slot-btn.timeslotdisabled {
        background-color: #e9ecef !important;
        color: #6c757d !important;
        cursor: not-allowed !important;
        border-color: #dee2e6 !important;
    }

    .time-slot-btn.timeslotdisabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Layout Improvements */
    .date-selector-wrapper {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .time-slot-wrapper {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-top: 10px;
    }

    .overview-booking-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .overview-booking-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .overview-booking-list li {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    .overview-booking-list li::before {
        content: '';
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 8px;
        border-radius: 50%;
    }

    .overview-booking-list li.available::before {
        background-color: #28a745;
    }

    .overview-booking-list li.booked::before {
        background-color: #dc3545;
    }

    .overview-booking-list li.selected::before {
        background-color: #007bff;
    }

    .overview-date-area {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #dee2e6;
    }

    .overview-date-header .title {
        font-size: 18px;
        color: #495057;
        margin-bottom: 15px;
        font-weight: 600;
    }

    /* Form Styling */
    .booking-appoint-form-area {
        background: #ffffff;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .booking-appoint-form-area .title {
        font-size: 20px;
        color: #495057;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
    }

    .booking-appoint-form .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .booking-appoint-form .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .booking-appoint-form textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .cmn-btn {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .cmn-btn:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .cmn-btn[data-value="1"] {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }

    .cmn-btn[data-value="1"]:hover {
        background: linear-gradient(135deg, #1e7e34, #155724);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .scroll-btn {
            min-width: 70px;
            font-size: 13px;
            padding: 10px 12px;
        }
        
        .date-btn {
            min-width: 75px;
            padding: 8px 10px;
        }
        
        .date-btn .date-number {
            font-size: 18px;
        }
        
        .time-slot-btn {
            min-width: 90px;
            padding: 8px 12px;
        }
        
        .overview-booking-list {
            justify-content: center;
            gap: 15px;
        }
        
        .overview-booking-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .overview-booking-header-left {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 576px) {
        .scroll-wrapper {
            gap: 8px;
        }
        
        .scroll-btn {
            min-width: 65px;
            font-size: 12px;
            padding: 8px 10px;
        }
        
        .date-btn {
            min-width: 70px;
        }
        
        .time-slot-btn {
            min-width: 85px;
        }
    }

    /* Additional Styling */
    .icon-colored {
        color: #007bff;
    }

    .nav-tabs .nav-link {
        border: 2px solid transparent;
        border-radius: 8px 8px 0 0;
        font-weight: 500;
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .tab-content {
        border: 2px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 8px 8px;
        padding: 20px;
        background: white;
    }
</style>
@endpush

@push('script')
<script>
(function($) {
    "use strict";

    // Handle time slot selection
    $(".available-time").on('click', function() {
        if ($(this).hasClass("timeslotdisabled")) return;

        $(".available-time").removeClass("selected");
        $(this).addClass("selected");

        $('.time').val($(this).data('value'));
    });

    // Handle date selection
    $('#custom-date-select .date-btn').on('click', function () {
        $('#custom-date-select .date-btn').removeClass('active');
        $(this).addClass('active');

        const selectedDate = $(this).data('date');
        $('#timeslotedate').val(selectedDate).trigger('change');
    });

    // Form field handlers
    $("[name=name]").on('input', function() {
        $('.name').text($(this).val());
    });
    
    $("[name=age]").on('input', function() {
        $('.age').text($(this).val());
    });
    
    $("[name=email]").on('input', function() {
        $('.email').text($(this).val());
    });
    
    $("[name=mobile]").on('input', function() {
        $('.mobile').text($(this).val());
    });

    // Reset form
    $(".reset").on('click', function() {
        $('.appointment-from')[0].reset();
    });

    // Payment system selection
    $('.payment-system').on('click', function() {
        $('.payment').val($(this).data('value'));
    });

    // Initialize date change trigger
    $("#timeslotedate").trigger('change');

})(jQuery);

// Check previous time slots

        function checkPrevTimeSlot($now){ 
            var jsNowDate = new Date($now);
            $('.book-time').text("");
            $('.time').val("");

            $('.available-time').each(function(i, item) {
                $(item).removeClass("timeslotdisabled");

                var time = $(item).data('value');

                var dateString = $("select[name=booking_date]").select2("val") +" "+time;
                // Convert to standard format (YYYY-MM-DDTHH:mm:ss)
                var formattedDateString = dateString.replace(" am", "").replace(" pm", "").replace(":", "-");
                var [year, month, day, hour, minute] = formattedDateString.split(/[-\s:]/);

                // Convert 12-hour format to 24-hour format
                let hours = parseInt(hour);
                if (dateString.includes("pm") && hours !== 12) {
                    hours += 12;
                } else if (dateString.includes("am") && hours === 12) {
                    hours = 0;
                }
                // Create Date object
                var jsDate = new Date(year, month - 1, day, hours, minute);
                
                if (jsNowDate > jsDate) {
                    $(this).addClass("timeslotdisabled");
                } 
            });
        }
  
   
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtons = document.querySelectorAll('.save-doctor');

            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const doctorId = this.dataset.doctorId;
                    const icon = this.querySelector('i');
                    const textSpan = this.querySelector('.save-text');

                    // Simulate saving (replace with your actual AJAX call)
                    this.classList.toggle('saved');
                    if (this.classList.contains('saved')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        textSpan.textContent = '@lang('Saved')';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        textSpan.textContent = '@lang('Save')';
                    }
                    // You would typically send an AJAX request here to save/unsave the doctor
                    console.log(`Doctor ID ${doctorId} saved/unsaved`);
                });
            });

            // Smooth scrolling for "Learn More" and "Book Appointment" buttons
            const smoothScrollLinks = document.querySelectorAll('.smooth-scroll');
            smoothScrollLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });


        function handleSlotChange(targetId) {
        const trigger = document.querySelector(`[data-bs-target="${targetId}"]`);
        if (trigger) {
            const tab = new bootstrap.Tab(trigger);
            tab.show();
        }
    }


    $(document).ready(function () {
    // Handle date selection
    $('#custom-date-select .date-btn').on('click', function () {
        $('#custom-date-select .date-btn').removeClass('active');
        $(this).addClass('active');

        const selectedDate = $(this).data('date');
        $('#timeslotedate').val(selectedDate).trigger('change');
    });

    // Handle time slot selection
    $('#time-slot-select .time-slot-btn').on('click', function () {
        $('#time-slot-select .time-slot-btn').removeClass('selected');
        $(this).addClass('selected');

        const selectedTime = $(this).data('value');
        $('.time').val(selectedTime);
    });
});
$(document).ready(function () {
    // Handle date selection
    $('#custom-date-select .date-btn').on('click', function () {
        $('#custom-date-select .date-btn').removeClass('active');
        $(this).addClass('active');

        const selectedDate = $(this).data('date');
        $('#timeslotedate').val(selectedDate).trigger('change');
    });
});




    </script>
@endpush