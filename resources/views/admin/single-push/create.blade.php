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
            color: black;
        }
    </style>    
    
    @section('title')
        {{ 'Creating New Single Push' }}
    @endsection    
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Create Single Push</h3> --}}
                        <div class="card-tools">
                            <a href="{{ route('admin.push.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form class="needs-validation" novalidate action="{{ route('admin.push.store') }}" method="POST">
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
                                        <label for="title" class="form-label">Enter Push Title</label>
                                        <input type="text" name="title" id="title" value="{{ old('app_name') }}"
                                            class="form-control" placeholder="Enter Title">
                                        <x-error :field="'title'" />
                                    </div>
                                </div>                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Enter Push Message <span class="astrik">*</span></label>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Enter Description">
                                            {{ old('description') }}
                                        </textarea>
                                        <x-error :field="'description'" />
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="url" class="form-label">Enter Launch URL</label>
                                        <input type="url" name="url" id="url" value="{{ old('url') }}"
                                            class="form-control" placeholder="Enter Url">
                                        <x-error :field="'url'" />
                                    </div>
                                </div> 
                                <div class="col-lg-12">
                                    <label for="delivery_schedule">Delivery Schedule</label>
                                </div>                              
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="mr-4">
                                            <input type="radio" name="delivery_type" value="immediate" {{old('delivery_type', 'immediate') === 'immediate' ? 'checked': '' }}  >
                                            Immediately
                                        </label>
                                        <label>
                                            <input type="radio" name="delivery_type" value="scheduled" {{old('delivery_type') === 'scheduled' ? 'checked': '' }}>
                                            Specific Time
                                        </label>
                                    </div>    
                                </div>                                
                                <div class="col-lg-4" id="date_time-col">
                                        <div class="form-group">
                                            <label for="scheduled_time">Scheduled Date/Time <span class="astrik">*</span></label>
                                            <input type="text" class="form-control"
                                            id="scheduled_time" name="scheduled_time" value="{{ old('scheduled_time') }}" required/>
                                            <x-error :field="'scheduled_time'" />
                                        </div>   
                                </div>
                                <div class="col-lg-4" id="timezone-col">
                                    <div class="form-group">
                                        <label for="timezone" >Timezone <span class="astrik">*</span></label>
                                            <select name="timezone" id="timezone" class="form-select timezone-select">
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
                                </div>
                                <div class="col-lg-4" id="optimize-col">
                                    <div class="form-group">
                                        <label for="optimization">Per User Optimization?</label>
                                        <div>
                                            <label>
                                                <input type="radio" name="optimize_type" value="same_time" {{old('optimize_type', 'same_time') === 'same_time' ? 'checked': '' }}  >
                                                Send to everyone at the same time
                                            </label>
                                            <label>
                                                <input type="radio" name="optimize_type" value="intelligent" {{old('optimize_type') === 'intelligent' ? 'checked': '' }}>
                                                Intelligent Delivery
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit" class="btn btn-primary float-right">Send</button>
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
        var customDate = moment();
           $('#scheduled_time').daterangepicker({
           timePicker: true,
           singleDatePicker: true,
           startDate: customDate,
           minDate: customDate,
           showDropdowns: true,
           autoUpdateInput: false,
           locale: {
               format: 'MM-DD-YYYY HH:mm:ss',
               cancelLabel: 'Clear'
           }
       });
       $('#scheduled_time').data('daterangepicker').setStartDate(customDate);
       $('#scheduled_time').val(customDate.format('MM-DD-YYYY HH:mm:ss'));
       // Clear the input field on cancel
       $('#scheduled_time').on('cancel.daterangepicker', function (ev, picker) {
           $(this).val('');
       });
        // Event handler for 'scheduled' date picker
        $('#scheduled_time').on('apply.daterangepicker', function (ev, picker) {
            var selectedDate = picker.startDate.format('MM-DD-YYYY HH:mm:ss');
        //    var timezone = $('#timezone').val();
           $(this).val(selectedDate);
        //    $('#scheduled_timezone').val(timezone);
       });
       
        // time zone select
        $('.timezone-select').select2({
                width: '100%', 
                placeholder: "Select a timezone",
                allowClear: true
            });
                function toggleScheduleOptions() {
                    if ($('input[name="delivery_type"]:checked').val() === 'scheduled') {
                        $('#date_time-col, #timezone-col , #optimize-col').show();
                    } else{
                        $('#date_time-col, #timezone-col , #optimize-col').hide();
                    }
                }
            $('input[name="delivery_type"]').change(toggleScheduleOptions);
              toggleScheduleOptions();
    </script>
    @endsection
</x-admin>
