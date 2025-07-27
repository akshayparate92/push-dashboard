<x-admin>
    @section('title')
        {{ 'Adding New App' }}
    @endsection
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Create Game</h3> --}}
                        <div class="card-tools">
                            <a href="{{ route('admin.game.index') }}" class="btn btn-info btn-sm">Back</a>
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
                    <form class="needs-validation" novalidate action="{{ route('admin.game.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="app_name" class="form-label">Enter App Name</label>
                                        <input type="text" name="app_name" id="app_name" value="{{ old('app_name') }}"
                                            class="form-control" required>
                                            <x-error :field="'app_name'" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="collection">Enter OneSignal App ID</label>
                                        <input type="text" name="app_id" id="app_id" value="{{ old('app_id') }}"
                                        class="form-control" required>
                                        <x-error :field="'app_id'" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="rest_api_key" class="form-label">Enter Rest API Key</label>
                                        <input type="text" name="rest_api_key" id="rest_api_key" value="{{ old('rest_api_key') }}"
                                        class="form-control" required>
                                        <x-error :field="'rest_api_key'" />
                                    </div>
                                </div>                               
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin>
