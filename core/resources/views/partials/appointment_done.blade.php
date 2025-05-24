<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Appointment Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group-flush list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Patient Name') :
                        <span class="name"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Booking Date') :
                        <span class="bookingDate"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Time or Serial no') :
                        <span class="timeSerial"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Contact No') :
                        <span class="mobile"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('E-mail') :
                        <span class="email"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Age') :
                        <span class="age"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Fees') :
                        <span class="appointment_fees"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Disease') :
                        <span class="disease text-end"></span>
                    </li>

                </ul>
                <hr>
                {{-- <div>
                    <p class="text--warning text-center"><i class="las la-exclamation-triangle"></i> @lang('Are you sure that the patient has paid')?
                    </p>
                    <p class="text-center text--success"><i class="las la-exclamation-triangle"></i> @lang('If yes, then you can mark this as service done').
                    </p>
                </div> --}}
                <div>
                    <form class="dealing-route" method="post">
                        @csrf
                        <input type="hidden" name="clinic_id" id="clinic_id">
                        <ul class="list-group-flush list-group">
                            <!-- all fields -->
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                @lang('Total Fees') :
                                <div class="input-group ms-auto" style="max-width: 200px;">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="consultation_fee" id="consultation_fee"
                                        class="form-control" placeholder="Enter amount" min="0" step="1"
                                        required>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                @lang('Reason') :
                                <textarea class="form-control  w-50" rows="2" placeholder="Reason for extra charge" name="reason_for_extra_charge"
                                    id="reason_for_extra_charge"></textarea>
                            </li>
                        </ul>
                        <hr>
                        <div>
                            <p class="text--warning text-center"><i class="las la-exclamation-triangle"></i>
                                @lang('Are you sure that the patient has paid')?</p>
                            <p class="text-center text--success"><i class="las la-exclamation-triangle"></i>
                                @lang('If yes, then you can mark this as service done').</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline--success btn-sm serviceDoneBtn">
                                <i class="las la-check"></i> @lang('Done')
                            </button>
                            <button type="button" class="btn btn-outline--dark btn-sm" data-bs-dismiss="modal">
                                <i class="las la-times"></i>@lang('Close')
                            </button>
                        </div>
                    </form>

                    {{-- <form class="dealing-route" method="post">
                    @csrf
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        @lang('Total Fees') :
                        <div class="input-group ms-auto" style="max-width: 200px;">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="consultation_fee" id="consultation_fee" class="form-control"
                                placeholder="Enter amount" min="0" step="1">
                        </div>
                    </li>
                    <button type="submit" class="btn btn-outline--success btn-sm serviceDoneBtn"><i
                            class="las la-check"></i> @lang('Done')</button>
                    <button type="button" class="btn btn-outline--dark btn-sm" data-bs-dismiss="modal"><i
                            class="las la-times"></i>@lang('Close')</button>
                </form> --}}
                </div>
            </div>

        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var resourse = $(this).data('resourse');


                $('.name').text(resourse.name);
                $('.email').text(resourse.email);
                $('.mobile').text(resourse.mobile);
                $('.bookingDate').text(resourse.booking_date);
                $('.timeSerial').text(resourse.time_serial);
                $('.age').text(resourse.age);
                $('.appointment_fees').text(resourse.clinic.fees + ' ' + `{{ gs('cur_text') }}`);
                $('.disease').text(resourse.disease);

                $('#clinic_id').val(resourse.clinic.id);

                var route = $(this).data('route');
                $('.dealing-route').attr('action', route);

                if (resourse.is_delete == 1 || resourse.is_complete == 1) {
                    modal.find('.serviceDoneBtn').hide();
                } else if (!resourse.is_complete && resourse.payment_status != 2) {
                    modal.find('.serviceDoneBtn').show();
                } else {
                    modal.find('.serviceDoneBtn').show();
                }

                modal.modal('show');
            });

            $('.removeBtn').on('click', function() {
                var modal = $('#removeModal');
                var route = $(this).data('route');
                $('.remove-route').attr('action', route);
            });

        })(jQuery);
    </script>
@endpush
