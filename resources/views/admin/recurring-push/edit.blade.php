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
        .id-column{
            display: none;
        }
    </style>    
    
    @section('title')
        {{ 'Manage multiple Push' }}
    @endsection 
    {{-- Table for all push --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Send To: {{ $appName }} | Date/Time: {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$recurringPushes->first()->start_time)->format('m-d-Y H:i') ?? null }} | Frequency: {{Str::ucfirst($recurringPushes->first()->frequency)}}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.recurring.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <table class="table table-striped" id="editRecurringSchedulePushTable">
                            <thead>
                                <tr>
                                    <th class="id-column">ID</th>
                                    <th>Push Title</th>
                                    <th>Push Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recurringPushes as $message)
                                @if($message->description !== null)
                                    <tr>
                                        <td class="id-column">{{$message->id}}</td>
                                        <td>{{ $message->title === "\u{2063}" || $message->title === '' ? 'No title': str_replace('&nbsp;', ' ', $message->title) }}</td>
                                        <td>{{ $message->description === "\u{2063}" ? 'No Content': str_replace('&nbsp;', ' ', $message->description) }}</td>
                                        <td>
                                            <form  action="{{ route('admin.recurring.push.destroy', encrypt($message->id)) }}" method="POST"
                                                onsubmit="return confirm('Are sure want to delete?')" >
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif    
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
                    </div>
                    <form class="needs-validation" novalidate action="{{ route('admin.recurring.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{$recurringPushes->first()->game_id}}" name="game_id" />
                        <input type="hidden" value="{{$recurringPushes->first()->start_time}}" name="start_time" />
                        <input type="hidden" value="{{$recurringPushes->first()->frequency}}" name="frequency" />
                        <input type="hidden" value="{{$recurringPushes->first()->optimize_type}}" name="optimize_type" />
                        <div class="card-body">
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
        var editRecurringPushTable= $('#editRecurringSchedulePushTable').DataTable({
                                        "paging": true,
                                        "searching": true,
                                        // "ordering": true,
                                        "responsive": true,
                                        "order": [[ 0, "desc" ]], 
                                        "columnDefs": [
                                            { "targets": 0, "visible": false }
                                        ]
                                    });       
     
       
    </script>
    @endsection
</x-admin>
