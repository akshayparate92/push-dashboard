<x-admin>
    @section('title','My Apps')
    <div class="card">
        <div class="card-header">
            {{-- <h3 class="card-title">Game Table</h3> --}}
            <div class="card-tools">
                <a href="{{ route('admin.game.create') }}" class="btn btn-sm btn-info">Add New App</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="gameTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>OneSignal App ID</th>
                        <th>REST API Key</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $game)
                        <tr>
                            <td>{{ $game->app_name }}</td>
                            <td>{{ $game->app_id }}</td>
                            <td>Hidden Content</td>
                            <td><a href="{{ route('admin.game.edit', encrypt($game->id)) }}"
                                    class="btn btn-sm btn-primary">Edit</a></td>
                            <td>
                                <form action="{{ route('admin.game.destroy', encrypt($game->id)) }}" method="POST"
                                    onsubmit="return confirm('Are sure want to delete?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @section('js')
        <script>
            $(function() {
                $('#gameTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    columnDefs: [{
                        targets: 2,
                        render: function(data, type, row, meta) {
                           return data = '********';
                        }
                    }],
                });
            });
        </script>
    @endsection
</x-admin>
