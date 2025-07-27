<x-admin>
    @section('css')
        <style>
            .modal-dialog {
                max-width: 700px;
            }

            .select2-container .select2-selection--single {
                height: 37px;
            }
            .id-column{
            display: none;
        }
        </style>
    @section('title', 'Multiple Push')

    <div class="card">
        <div class="card-header">
            {{-- <h3 class="card-title">Recurring Push Table</h3> --}}
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-info" id="addAppFrequency"><i class="fa fa-hourglass"></i>
                   Add New Schedule</button>
            </div>
            {{-- Add Schedule model --}}
            <div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Schedule Recurring Push </h5>
                            <button type="button" id="closeCreateScheduleModal" class="btn-sm btn-danger"
                                data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="alert alert-danger d-none" id="errorAlert"></div>
                        <form id="createScheduleForm" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-4 my-1">
                                        <label for="app_name" style="text-align: left !important"
                                            class="col-form-label">App Name <span class="astrik">*</span></label>
                                    </div>
                                    <div class="col-lg-6 my-1">
                                        @php
                                            $allApps = App\Models\Game::get();
                                        @endphp
                                        <select name="app_name" id="app_name" class="form-control">
                                            <option value="">Select App Name</option>
                                            <option value="all">All Apps</option>
                                            @foreach ($allApps as $app)
                                                <option value="{{ $app->id }}">{{ $app->app_name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="app_name-error" class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-lg-4 my-1">
                                        <label for="frequency" style="text-align: left !important"
                                            class="col-form-label">Frequency <span class="astrik">*</span></label>
                                    </div>
                                    <div class="col-lg-6 my-1">
                                        <select name="frequency" id="frequency" class="form-control">
                                            <option value="">Select frequency</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                        <div id="frequency-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-lg-4 my-1">
                                        <label for="start_date" style="text-align: left !important"
                                            class="col-form-label">Start Date <span class="astrik">*</span></label>
                                    </div>
                                    <div class="col-lg-6 my-1">
                                        <input type="text" class="form-control" name="start_date"
                                            placeholder="Select Start Date" id="start_date" autocomplete="off">
                                        <div id="start_date-error" class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-lg-4 my-1">
                                        <label for="delivery_time" style="text-align: left !important"
                                            class="col-form-label">Delivery Time <span class="astrik">*</span></label>
                                    </div>
                                    <div class="col-lg-3 my-1">
                                        <label>
                                            <input type="radio" name="delivery_type" value="same_time" checked>
                                            Fixed
                                        </label>
                                    </div>
                                    <div class="col-lg-5 my-1">
                                        <label>
                                            <input type="radio" name="delivery_type" value="intelligent">
                                            Intelligent Delivery
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4" id="time-col">
                                        <div class="form-group">
                                            <label for="scheduled_time">Time <span class="astrik">*</span></label>
                                            <input type="time" class="form-control" id="scheduled_time"
                                                name="scheduled_time" autocomplete="off" />
                                            <div id="scheduled_time-error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="timezone-col">
                                        <div class="form-group">
                                            @php
                                                $defaultTimezone = config('app.timezone');
                                            @endphp
                                            <label for="timezone">Timezone <span class="astrik">*</span></label>
                                            <select name="timezone" id="timezone"
                                                class="form-control timezone-select">

                                                <option value="">Select TimeZone</option>
                                                @foreach (timezone_identifiers_list() as $timezone)
                                                    <option value="{{ $timezone }}"
                                                        {{ $defaultTimezone === $timezone ? 'selected' : '' }}>
                                                        {{ $timezone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="timezone-error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="cancelCreateScheduleModal"><i class="fa fa-minus-circle"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-hourglass"></i>
                                    Save Schedule </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End schedule model --}}
        </div>
        <div class="card-body">
            <table class="table table-striped" id="recurringPushTable">
                <thead>
                    <tr>
                        <th class="id-column">ID</th>
                        <th>App Name</th>
                        <th>Frequency</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indexData as $appName => $groupedMessages)
                        @foreach ($groupedMessages->groupBy('frequency') as $frequency => $messages)
                            <tr>
                                <td class="id-column">{{ $messages->first()->updated_at }}</td>
                                <td>{{ $appName }}</td>
                                <td>{{ Str::ucfirst($frequency) }}</td>
                                <td>
                                    {!! $messages->first()->status === 'pending'
                                        ? '<span class="badge badge-warning">' . $messages->first()->status . '</span>'
                                        : ($messages->first()->status === 'scheduled'
                                            ? '<span class="badge badge-success">' . $messages->first()->status . '</span>'
                                            : ($messages->first()->status === 'stopped'
                                                ? '<span class="badge badge-danger">Stopped</span>'
                                                : $messages->first()->status)) !!}
                                </td>
                                <td>
                                    <form
                                        action="{{ route('admin.edit.recurring.push', ['game' => $messages->first()->game_id ?? 'all', 'frequency' => $frequency]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">Manage Push</button>
                                    </form>
                                </td>
                                <td>
                                    <form
                                        action="{{ route('admin.delete.recurring.push', ['game' => $messages->first()->game_id ?? 'all', 'frequency' => $frequency]) }}"
                                        method="POST" onsubmit="return confirm('Are sure want to delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="btnDelete"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @section('js')
        <script>
            $(function() {
                // table for app schedule register
                var recurringPushTable = $('#recurringPushTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "responsive": true,
                    "order": [[ 0, "desc" ]], 
                    "columnDefs": [
                        { "targets": 0, "visible": false }
                    ]
                });
                // submit app schedule form
                $('#addAppFrequency').on('click', function() {
                    $('#createScheduleModal').modal('show');
                    $('#createScheduleForm').validate({
                        rules: {
                            app_name: {
                                required: true,
                            },
                            frequency: {
                                required: true,
                            },
                            start_date: {
                                required: true,
                            },
                            scheduled_time: {
                                required: true,
                            },
                            timezone: {
                                required: true,
                            }
                        },
                        // //  validation error messages
                        messages: {
                            app_name: {
                                required: "Please select app name"
                            },
                            frequency: {
                                required: "Please select frequency"
                            },
                            start_date: {
                                required: "Please enter start date",
                            },
                            scheduled_time: {
                                required: "Please enter Time",
                            },
                            timezone: {
                                required: "Please select Timezone",
                            }
                        },
                        // Specify success handler to clear error messages and classes

                        errorPlacement: function() {
                            return false;
                        },
                        // Specify form submission handler
                        submitHandler: function(form) {
                            // Submit the form via AJAX
                            $.ajax({
                                url: "{{ route('admin.submit.recurring.push.schedule') }}", // Specify your form submission URL
                                type: 'POST',
                                data: $(form).serialize(),
                                success: function(response) {
                                    // Handle success
                                    // For example, close the modal
                                    console.log(response);
                                    $('#createScheduleModal').modal('hide');
                                    if (response.status == 'success') {
                                        toastr.success(
                                            'Scheduled Time is enabled for .',
                                            "Success", {
                                                "closeButton": true,
                                                "progressBar": true,
                                            });
                                    } else {
                                        toastr.error('Failed to Scheduled App Time.',
                                            "Error", {
                                                "closeButton": true,
                                                "progressBar": true,
                                            });
                                    }
                                    window.location.reload();      

                                },
                                error: function(xhr) {
                                    // Handle errors
                                    var errorMessage = xhr.responseJSON.msg;
                                    $('#errorAlert').text(errorMessage).removeClass(
                                        'd-none');

                                    toastr.error('Failed to Scheduled App Time.',
                                        "Error", {
                                            "closeButton": true,
                                            "progressBar": true,
                                        });
                                }
                            });
                            return false; // Prevent normal form submission
                        },
                        // Specify invalid handler to manually display error messages
                        invalidHandler: function(form, validator) {
                            $.each(validator.errorList, function(index, error) {
                                var input = $(error.element);
                                var errorMessage = $('<div class="error-message">').text(
                                        error.message)
                                    .addClass('text-danger');
                                var errorContainer = $('#' + input.attr('id') + '-error')
                                    .empty()
                                    .append(errorMessage);
                                input.addClass('is-invalid');
                            });
                        },
                        success: function(label) {
                            var id = $(label).attr('id');
                            var errorContainer = $('#' + id);
                            errorContainer.empty();
                            var inputID = id.substring(0, id.length - 6);
                            $('#' + inputID).removeClass('is-invalid');
                        },

                    });
                });

                // reset form on close
                function resetForm() {
                    var form = $('#createScheduleForm');
                    form[0].reset(); // Reset the form fields
                    form.validate().resetForm(); // Reset the validation state
                    form.find('.is-invalid').removeClass('is-invalid'); // Remove all 'is-invalid' classes
                    form.find('.invalid-feedback').empty();
                }
                $('#closeCreateScheduleModal').on('click', function() {
                    // alert();
                    resetForm();
                });
                $('#cancelCreateScheduleModal').on('click', function() {
                    resetForm();
                });
                // time zone select
                $('.timezone-select').select2({
                    width: '100%',
                    placeholder: "Select a timezone",
                    allowClear: true
                });

                function toggleScheduleOptions() {
                    if ($('input[name="delivery_type"]:checked').val() === 'intelligent') {
                        $('#time-col, #timezone-col').hide();
                    } else {
                        $('#time-col, #timezone-col').show();
                    }
                }
                $('input[name="delivery_type"]').change(toggleScheduleOptions);
                toggleScheduleOptions();


                var customDate = moment();
                $('#start_date').daterangepicker({
                    singleDatePicker: true,
                    minDate: customDate,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    locale: {
                        format: 'MM-DD-YYYY',
                        cancelLabel: 'Clear'
                    }
                });
                $('#start_date').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                // Event handler for 'scheduled' date picker
                $('#start_date').on('apply.daterangepicker', function(ev, picker) {
                    var selectedDate = picker.startDate.format('MM-DD-YYYY');
                    $(this).val(selectedDate);
                });
            });
        </script>
    @endsection
</x-admin>
