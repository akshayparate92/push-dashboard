<x-admin>
    @section('css')
    <style>
        .select2-container--default .select2-selection--single{
            background-color: white !important;
            
        }
        .select2-container .select2-selection--single{
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            color: rgb(27, 25, 25);
        }
        .modal-dialog{
            max-width: 700px;
        }
    </style>    
    
    @section('title')
        {{ 'Create Recurring Push' }}
    @endsection 
    {{-- Table for all push --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Recurring Pushes for schedule </h3>
                        <button id="ceateScheduleBtn" class="mx-3 btn btn-sm btn-success" type="button"><i class="nav-icon fa fa-calendar"></i> Schedule</button>
                        <div class="card-tools">
                            <a href="{{ route('admin.recurring.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                     {{-- Add Schedule model --}}
                    <div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Schedule Recurring Push </h5>
                                    <button type="button" id="closeCreateScheduleModal" class="btn-sm btn-danger" data-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <form id="createScheduleForm" method="POST" >
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                                <div class="col-lg-4 my-1">
                                                    <label for="frequency" style="text-align: left !important" class="col-form-label">Frequency <span class="astrik">*</span></label>
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
                                                <label for="start_date" style="text-align: left !important" class="col-form-label">Start Date <span class="astrik">*</span></label>
                                            </div>
                                            <div class="col-lg-6 my-1">
                                                    <input type="text" class="form-control" name="start_date" placeholder="Select Start Date"
                                                    id="start_date" autocomplete="off">                                                
                                                <div id="start_date-error" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-lg-4 my-1">
                                                <label for="delivery_time" style="text-align: left !important" class="col-form-label">Delivery Time <span class="astrik">*</span></label>
                                            </div>
                                            <div class="col-lg-3 my-1">
                                                <label>
                                                    <input type="radio" name="delivery_type" value="fixed" checked >
                                                    Fixed
                                                </label>
                                            </div>
                                            <div  class="col-lg-5 my-1">
                                                <label>
                                                    <input type="radio" name="delivery_type" value="intelligent">
                                                    Intelligent Delivery
                                                </label>
                                            </div>
                                            <div class="col-lg-4">
                                            </div>  
                                            <div class="col-lg-2" id="time-col">
                                                <div class="form-group">
                                                    <label for="scheduled_time">Time <span class="astrik">*</span></label>
                                                    <input type="time" class="form-control"
                                                    id="scheduled_time" name="scheduled_time" autocomplete="off"/>
                                                    <div id="scheduled_time-error" class="invalid-feedback"></div>
                                                </div>   
                                            </div> 
                                            <div class="col-lg-6" id="timezone-col">
                                                <div class="form-group">
                                                             @php
                                                            $defaultTimezone = config('app.timezone');
                                                            @endphp
                                                    <label for="timezone" >Timezone <span class="astrik">*</span></label>
                                                        <select name="timezone" id="timezone" class="form-control timezone-select">
                                                            
                                                                <option value="">Select TimeZone</option>
                                                            @foreach (timezone_identifiers_list() as $timezone)
                                                                <option value="{{ $timezone }}" {{ $defaultTimezone === $timezone ? 'selected' : '' }}>
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
                                            Schedule</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     {{-- End schedule model --}}
                    <div class="card-body">
                        <table class="table table-striped" id="createRecurringSchedulePushTable">
                            <thead>
                                <tr>
                                    <th>App Name</th>
                                    <th>Push Name</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    {{-- <th>Schedule Time</th> --}}
                                    <th>Frequency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $game)
                                    <tr>
                                        <td>{{ $game->game === null ? 'All Games': $game->game->app_name  }}</td>
                                        <td>{{ $game->description === "\u{2063}" ? 'No Content': str_replace('&nbsp;', ' ', $game->description) }}</td>
                                        <td>
                                            {!! 
                                        ($game->status === 'pending') 
                                        ? '<span class="badge badge-warning">'.$game->status.'</span>' 
                                        : (($game->status === 'scheduled')
                                            ? '<span class="badge badge-success">'.$game->status.'</span>'
                                            : (($game->status === 'scheduled')
                                            ? '<span class="badge badge-danger">'.$game->status.'</span>'
                                            : '<span class="badge badge-info">'.$game->status.'</span>')) 
                                            !!}
                                        </td>
                                        <td>{{ $game->start_time === null ? 'Inteligent Delivery': Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$game->start_time)->format('m-d-Y H:i:s') }}</td>
                                        {{-- <td>{{ $game->scheduled_time === null ? ' ': Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$game->scheduled_time)->format('H:i:s') }} </td> --}}
                                        <td>{{ $game->frequency === null ? '': $game->frequency }}</td>
                                        <td>
                                            <form id="delete-form-{{$game->id}}" action="{{ route('admin.recurring.destroy', encrypt($game->id)) }}" method="POST"
                                                >
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"  {{ $game->status === 'pending'|| $game->status === 'assigned' ? 'disabled':'' }}>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Recurring Push</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.recurring.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route('admin.recurring.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        @php
                                            $allGames = App\Models\Game::select('id','app_name')->orderBy('created_at','DESC')->get();
                                        @endphp
                                        <label for="game_id" >Select App </label>
                                            <select name="game_id" id="game_id" class="form-control">
                                                <option value="">All Apps</option>
                                                @foreach ( $allGames as $game)
                                                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? ' selected' : '' }}>
                                                        {{ $game->app_name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                    </div> 
                                </div>
                            </div>           
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" value="{{ old('app_name') }}"
                                            class="form-control" placeholder="Enter Title">
                                        <x-error :field="'title'" />
                                    </div>
                                </div>                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description <span class="astrik">*</span></label>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Enter Description">
                                            {{ old('description') }}
                                        </textarea>
                                        <x-error :field="'description'" />
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="url" class="form-label">Launch URL</label>
                                        <input type="url" name="url" id="url" value="{{ old('url') }}"
                                            class="form-control" placeholder="Enter Url">
                                        <x-error :field="'url'" />
                                    </div>
                                </div>                               
                                {{-- <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="delivery_type" value="intelligent" {{old('delivery_type', 'intelligent') === 'intelligent' ? 'checked': '' }}  >
                                            Intelligent Delivery
                                        </label>
                                        <label>
                                            <input type="radio" name="delivery_type" value="scheduled" {{old('delivery_type') === 'scheduled' ? 'checked': '' }}>
                                            Schedule Time
                                        </label>
                                    </div>    
                                </div>                                 --}}
                                {{-- <div class="col-lg-6" id="date_time-col">
                                        <div class="form-group">
                                            <label for="scheduled_time">Scheduled Date/Time <span class="astrik">*</span></label>
                                            <input type="text" class="form-control"
                                            id="scheduled_time" name="scheduled_time" value="{{ old('scheduled_time') }}" required/>
                                            <x-error :field="'scheduled_time'" />
                                        </div>   
                                </div> --}}
                                {{-- <div class="col-lg-6" id="timezone-col">
                                    <div class="form-group">
                                        <label for="timezone" >Timezone <span class="astrik">*</span></label>
                                            <select name="timezone" id="timezone" class="form-select timezone-select" required>
                                                @php
                                                $defaultTimezone = config('app.timezone');
                                                @endphp
                                                    <option value="">Select TimeZone</option>
                                                @foreach (timezone_identifiers_list() as $timezone)
                                                    <option value="{{ $timezone }}" {{ old('timezone', $defaultTimezone) == $timezone ? ' selected' : '' }}>
                                                        {{ $timezone }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        <x-error :field="'timezone'" />
                                    </div>            
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit" class="btn btn-primary float-right">Save and Add Another</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script type="text/javascript">
        var pushStoreImageRoute = "{{route('admin.tinymce.image.upload')}}";   
   </script>
   
   <script>
        // scheduled single push Notification   
        //    var customDate = moment().add(1, 'days');
        $(function() {
               var createRecurringPushTable= $('#createRecurringSchedulePushTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                });     
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
               $('#start_date').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                });
                // Event handler for 'scheduled' date picker
                $('#start_date').on('apply.daterangepicker', function (ev, picker) {
                var selectedDate = picker.startDate.format('MM-DD-YYYY');
        //    var timezone = $('#timezone').val();
                 $(this).val(selectedDate);
        //    $('#scheduled_timezone').val(timezone);
             });
           
          // submit schedule form
          $('#ceateScheduleBtn').on('click',function(){
                $('#createScheduleModal').modal('show');
                $('#createScheduleForm').validate({
                    rules: {
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
                        order_reference: {
                            frequency: "Please select frequency"
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
                            url: "{{route('admin.submit.recurring.push.schedule')}}", // Specify your form submission URL
                            type: 'POST',
                            data: $(form).serialize(),
                            success: function(response) {
                                // Handle success
                                // For example, close the modal
                                $('#createScheduleModal').modal('hide');
                                    window.location.reload();
                                if (response.status === 'success') {
                                    toastr.success('Scheduled Time is enabled for recurring push.',
                                        "Success", {
                                            "closeButton": true,
                                            "progressBar": true,
                                        });
                                } else {
                                    toastr.error('Failed to Scheduled Time.', "Error", {
                                        "closeButton": true,
                                        "progressBar": true,
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle errors
                                toastr.error('Failed to Scheduled Time.', "Error", {
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
                            var errorMessage = $('<div class="error-message">').text(error.message)
                                .addClass('text-danger');
                            var errorContainer = $('#' + input.attr('id') + '-error').empty()
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
        });
    </script>
    @endsection
</x-admin>
