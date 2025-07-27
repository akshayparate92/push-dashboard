<x-admin>
    @section('title','Edit App')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Edit Game</h3> --}}
                        <div class="card-tools">
                            <a href="{{ route('admin.game.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route('admin.game.update', $data) }}"
                        method="POST" >
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="app_name" class="form-label">App Name</label>
                                        <input type="text" name="app_name" id="app_name" value="{{ $data->app_name }}"
                                            class="form-control" required>
                                            <x-error :field="'app_name'" /> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="app_id">OneSignal App ID</label>
                                        <input type="text" name="app_id" id="app_id" value="{{ $data->app_id }}"
                                        class="form-control" required>
                                        <x-error :field="'app_id'" />                                     
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="rest_api_key">Rest API Key (Leave Empty If dont want to change)</label>
                                        <input type="text" name="rest_api_key" id="rest_api_key" value=""
                                        class="form-control">
                                        <x-error :field="'rest_api_key'" />      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('product-image/' . $data->image) }}" alt="" class="w-full modal-img">
                    <span class="text-muted">If you want to change image just add new image otherwise leave it.</span>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}
    {{-- @section('js')
        <script>
            $("#category").on('change', function() {
                let category = $("#category").val();
                $("#submit").attr('disabled', 'disabled');
                $("#submit").html('Please wait');
                $.ajax({
                    url: "{{ route('admin.getsubcategory') }}",
                    type: 'GET',
                    data: {
                        category: category,
                    },
                    success: function(data) {
                        if (data) {
                            $("#submit").removeAttr('disabled', 'disabled');
                            $("#submit").html('Save');
                            $("#subcategory").html(data);
                        }
                    }
                });
            });
        </script>
    @endsection --}}
</x-admin>
