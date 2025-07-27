<x-admin>
    @section('css')
    <style>
        .id-column{
            display: none;
        }
        .table-cell {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px; /* Adjust according to your layout */
        }
    </style>
    @section('title','Single Push')
    <div class="card">
        <div class="card-header">
            {{-- <h3 class="card-title">Single Push Table</h3> --}}
            <div class="card-tools">
                <a href="{{ route('admin.push.create') }}" class="btn btn-sm btn-info">Add New Single Push</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="singlePushTable">
                <thead>
                    <tr>
                        <th class="id-column">ID</th>
                        <th>App Name</th>
                        <th>Push Title</th>
                        <th>Push Description</th>
                        <th>Send On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $game)
                        <tr>
                            <td class="id-column">{{$game->id}}</td>
                            <td>{{ $game->game === null ? 'All Apps': $game->game->app_name  }}</td>
                            <td>{{ $game->title === "\u{2063}" || $game->title === '' ? 'No Title': str_replace('&nbsp;', ' ', $game->title) }}</td>
                            <td class="table-cell">{{ $game->description === "\u{2063}" || $game->description === '' ? 'No Description': str_replace('&nbsp;', ' ', $game->description) }}</td>
                            <td>{{ $game->send_at === null ? 'Immediate Sent': Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$game->send_at)->format('m-d-Y H:i:s') }}</td>
                            <td>
                                <form id="delete-form-{{$game->id}}" action="{{ route('admin.push.destroy', encrypt($game->id)) }}" method="POST"
                                    >
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"  {{ $game->status === 'pending'? 'disabled':'' }}>Delete</button>
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
        var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    </script>
        <script>
                 $(function() {
                $('#singlePushTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "responsive": true,
                    "order": [[ 0, "desc" ]], 
                    "columnDefs": [
                        { "targets": 0, "visible": false },
                        { "targets": [2], "className": "table-cell" }
                    ]
                });

                $('form[id^="delete-form-"]').on('submit', function(e) {
                    var form = $(this);
                    var submitBtn = form.find('button[type="submit"]');
                    if (submitBtn.is(':disabled')) {
                        e.preventDefault(); // Prevent form submission if the button is disabled
                        return false;
                    }

                    if (!confirm('Are you sure you want to delete?')) {
                        e.preventDefault(); // Prevent form submission if the user cancels the confirmation
                        return false;
                    }
                });
            });
        </script>
    @endsection
</x-admin>
