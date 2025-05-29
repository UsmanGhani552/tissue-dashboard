@extends('layout.master')
@section('content')
    <div class="tab-content">


        <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Error Files ({{ $count }})</h2>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" href="{{ route('retry') }}" class="btn r-button retry-btn">Retry
                            <span id="button-spinner"
                                class="spinner-border spinner-border-sm d-none"></span></button>
                    </div>

                </div>
            </div>
            <div id="status-message" class="mt-3">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
            <div class="mainTable">
                <div class="container-fluid">
                    <div class="bottomTable">
                        <table class="table dataTable">
                            <thead class="">
                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <th style="width: 20%;">Sheet Id</th>
                                    <th style="width: 20%;">Folder</th>
                                    <th style="width: 40%;">Error Message</th>
                                </tr>
                            </thead>
                            <tbody class="overflow-auto">
                                @foreach ($error_files as $error_file)
                                    <tr>
                                        <td>{{ $error_file->file_name }}</td>
                                        <td>{{ $error_file->file_id }}</td>
                                        <td>{{ $error_file->folder->name }}</td>
                                        <td>{{ $error_file->page_message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.retry-btn').on('click', function () {
                // e.preventDefault();
                var button = $(this);
                var spinner = $('#button-spinner');
                const statusDiv = $('#status-message');
                statusDiv.html('<div class="alert alert-info">Preparing import...</div>');

                // Show the spinner
                spinner.removeClass('d-none');

                // Make the AJAX request
                $.ajax({
                    url: "{{ route('retry') }}",
                    type: "GET",
                    success: function (data) {
                        console.log(data);
                            // Handle error response if needed
                            spinner.addClass('d-none');
                            statusDiv.html('<div class="alert alert-success">'+data.message+'</div>');
                    },
                    error: function (xhr, status, error) {
                        console.log("Error fetching error files:", error);
                        spinner.addClass('d-none');
                        statusDiv.html('<div class="alert alert-danger">Something went wrong</div>');
                    },
                });
            });

        });
    </script>
@endpush