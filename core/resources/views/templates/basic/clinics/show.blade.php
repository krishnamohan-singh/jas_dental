@extends($activeTemplate . 'layouts.frontend')

@section('content')
<section class="clinic-details ptb-80">
    <div class="container">
        <div class="row">
                    <!-- Left Column: Doctors List -->
                    <div class="col-lg-5">

                        <!-- clinicS SECTION (Top) -->
                        <h2 class="text-center fw-bold mb-2 py-3" style="font-size: 2rem;">
                            @lang('Our Doctors')
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
                    <div class="col-lg-7">
                       
                            <div class="container">
                                <div class="overview-area mrb-40">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-item">
                                                <div class="overview-tab-content">
                                                    <div class="overview-booking-header d-flex flex-wrap justify-content-between ml-b-10">
                                                        <div class="overview-booking-header-left mrb-10">
                                                            @if ($clinic->serial_day && ($clinic->serial_or_slot || $clinic->serial_or_slot1 || $clinic->serial_or_slot2))
                                                                <h4 class="title">@lang('Available Schedule')</h4>
                                                                <ul class="overview-booking-list">
                                                                    <li class="available">@lang('Available')</li>
                                                                    <li class="booked">@lang('Booked')</li>
                                                                    <li class="selected">@lang('Selected')</li>
                                                                </ul>
                                                            @else
                                                                <h4 class="title">@lang('No Schedule Available Yet')</h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if ($clinic->serial_day && ($clinic->serial_or_slot || $clinic->serial_or_slot1 || $clinic->serial_or_slot2))
                                                        <form action="{{ route('doctor.appointment.store', $clinic->id) }}" method="post" class="appointment-from">
                                                            @csrf

                                                            <div class="overview-booking-area">
                                                                <div class="overview-booking-header-right mrb-10">
                                                                    <div class="overview-date-area d-flex flex-wrap align-items-center justify-content-between">
                                                                        <div class="overview-date-header">
                                                                            <h5 class="title">@lang('Choose Your Date & Time')</h5>
                                                                        </div>
                                                                        <div class="overview-date-select select2-parent">
                                                                            <select id="timeslotedate" class="form-control date-select select2-basic" name="booking_date" required>
                                                                                @foreach ($availableDate as $date)
                                                                                    <option value="{{ $date }}">{{ __($date) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Responsive Slot Navigation -->

                                                                <!-- Dropdown (Mobile View) -->
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

                                                                <!-- Tabs (Desktop View) -->
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

                                                                <div class="tab-content" id="slotTabContent">
                                                                    @if ($clinic->serial_or_slot)
                                                                        <div class="tab-pane fade show active" id="morning" role="tabpanel">
                                                                            <div><b>@lang('Morning Time Slot')</b></div>
                                                                            <hr>
                                                                            <ul class="clearfix time-serial-parent slot-scroll">
                                                                                @foreach ($clinic->serial_or_slot as $item)
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" class="btn mr-2 mb-2 available-time item-{{ slug($item) }}" data-value="{{ $item }}" data-d="{{ $item }}">{{ __($item) }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            <input type="hidden" name="time_serial" class="time" required>
                                                                        </div>
                                                                    @endif

                                                                    @if ($clinic->serial_or_slot1)
                                                                        <div class="tab-pane fade @if(!$clinic->serial_or_slot) show active @endif" id="afternoon" role="tabpanel">
                                                                            <div><b>@lang('Afternoon Time Slot')</b></div>
                                                                            <hr>
                                                                            <ul class="clearfix time-serial-parent slot-scroll">
                                                                                @foreach ($clinic->serial_or_slot1 as $item)
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" class="btn mr-2 mb-2 available-time item-{{ slug($item) }}" data-value="{{ $item }}">{{ __($item) }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            <input type="hidden" name="time_serial" class="time" required>
                                                                        </div>
                                                                    @endif

                                                                    @if ($clinic->serial_or_slot2)
                                                                        <div class="tab-pane fade @if(!$clinic->serial_or_slot && !$clinic->serial_or_slot1) show active @endif" id="evening" role="tabpanel">
                                                                            <div><b>@lang('Evening Time Slot')</b></div>
                                                                            <hr>
                                                                            <ul class="clearfix time-serial-parent slot-scroll">
                                                                                @foreach ($clinic->serial_or_slot2 as $item)
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" class="btn mr-2 mb-2 available-time item-{{ slug($item) }}" data-value="{{ $item }}">{{ __($item) }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            <input type="hidden" name="time_serial" class="time" required>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Booking & Form -->
                                                            <div class="booking-appoint-area">
                                                                <div class="row justify-content-center ml-b-30">
                                                                    <div class="col-lg-12 mrb-30">
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
                                                                                        <textarea name="disease" placeholder="@lang('Enter Disease Details')"></textarea>
                                                                                    </div>
                                                                                    <div class="col-lg-12 form-group d-flex flex-wrap justify-content-between">
                                                                                        <button type="submit" class="cmn-btn payment-system" data-value="2">@lang('Book Now')</button>
                                                                                        @if (gs('online_payment'))
                                                                                            {{-- Uncomment below to enable online payment --}}
                                                                                            {{-- <button type="submit" class="cmn-btn payment-system" data-value="1">@lang('Pay Online')</button> --}}
                                                                                        @endif
                                                                                        <input type="hidden" name="payment_system" class="payment" required>
                                                                                    </div>
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
     a.timeslotdisabled {
        background-color: #e7e7e7 !important;
        color: white !important;
        cursor: not-allowed;
    }

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
        background:rgb(168, 105, 16);
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



    
    /* Booking Area */
    .overview-section {
        padding-bottom: 80px;
        background-color: #f9f9f9;
    }

    .overview-area {
        margin-bottom: 40px;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .overview-booking-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center; /* Vertically align title and list */
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
    }

    .overview-booking-header-left {
        margin-bottom: 10px; /* Add some space below on smaller screens */
    }

    .overview-booking-header-left .title {
        font-size: 20px;
        margin-bottom: 10px;
        border-bottom: none; /* Remove duplicate border */
        padding-bottom: 0;
    }

    .overview-booking-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
    }

    .overview-booking-list li {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #777;
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
        background-color: #5cb85c;
    }

    .overview-booking-list li.booked::before {
        background-color: #d9534f;
    }

    .overview-booking-list li.selected::before {
        background-color: #007bff;
    }

    .overview-date-area {
        padding: 15px;
        background-color: #f0f8ff;
        border-radius: 6px;
        margin-bottom: 20px; /* Add margin below the date selector */
    }

    .overview-date-header .title {
        font-size: 16px;
        color: #555;
        margin-bottom: 8px;
        border-bottom: none; /* Remove duplicate border */
        padding-bottom: 0;
    }

    .time-serial-parent {
        list-style: none;
        padding: 0;
        margin: 10px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .time-serial-parent li a.btn--primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .time-serial-parent li a.btn--primary:hover {
        background-color:rgb(0, 99, 186);
    }

    .booking-appoint-area {
        margin-top: 30px;
    }

    .booking-appoint-form-area {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
    }

    .booking-appoint-form-area .title {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .booking-appoint-form .form-group {
        margin-bottom: 15px;
    }

    .booking-appoint-form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
        min-height: 80px;
    }

    .booking-appoint-form .cmn-btn {
        background-color: #28a745; /* Green for Book Now */
    }

    .booking-appoint-form .cmn-btn:hover {
        background-color: #1e7e34;
    }

    .booking-confirm-area {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f5f5f5;
    }

    .booking-confirm-area .title {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .booking-confirm-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .booking-confirm-list li {
        font-size: 14px;
        color: #555;
        margin-bottom: 8px;
    }

    .booking-confirm-list li span:first-child {
        font-weight: bold;
        margin-right: 5px;
    }
    confirm-list li .custom-color {
        color: #007bff; /* Blue for important information */
    }

    .booking-confirm-btn {
        margin-top: 20px;
        text-align: right;
    }

    .booking-confirm-btn .cmn-btn-active.reset {
        background-color: #dc3545; /* Red for Reset */
    }

    .booking-confirm-btn .cmn-btn-active.reset:hover {
        background-color: #c82333;
    }

    /* Responsive Adjustments - Moved to the end for clarity */
    @media (max-width: 991px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-header-left {
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-image {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .profile-header-right {
            flex-basis: 100%;
        }
    }

</style>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            $(".available-time").on('click', function() {
                if ($(this).hasClass("timeslotdisabled")) {
                    return;
                }
                $('.time').val($(this).data('value'));
                $('.book-time').text($(this).data('value'));
            })

            function slug(text) {
                return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            }

            $("select[name=booking_date]").on('change', function() {
                $('.date').text(`${$(this).val()}`); // Add date to view

                $('.available-time').removeClass('btn--success disabled').addClass('active-time');

                let url = "{{ route('doctors.appointment.available.date') }}";
                let data = {
                    date: $(this).val(),
                    clinic_id: '{{ $clinic->id }}'
                }

                $.get(url, data, function(response) {
                    if (!response.data.length) {
                        $('.available-time').removeClass('active-time disabled');
                    } else {
                        $.each(response.data, function(key, value) {
                            var demo = slug(value);
                            $(`.item-${demo}`).addClass('active-time disabled');
                        });
                    }

                    checkPrevTimeSlot(response.now);
                });
            });

            $("[name=name]").on('input', function() {
                $('.name').text(`${$(this).val()}`);
            });
            $("[name=age]").on('input', function() {
                $('.age').text(`${$(this).val()}`);
            });
            $("[name=email]").on('input', function() {
                $('.email').text(`${$(this).val()}`);
            });
            $("[name=mobile]").on('input', function() {
                $('.mobile').text(`${$(this).val()}`);
            });


            $(".reset").on('click', function() {
                $('.appointment-from')[0].reset();
            });

            $('.payment-system').on('click', function() {
                $('.payment').val($(this).data('value'));
            });

            $("#timeslotedate").change();


        })(jQuery);

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
    </script>
@endpush

