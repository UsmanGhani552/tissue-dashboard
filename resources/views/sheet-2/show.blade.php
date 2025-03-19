@extends('layout.master')
@section('content')
<div class="tab-content">
    <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
        <div class="container-fluid current-head">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Total Records</h2>
                </div>

                <div class="col-lg-6">
                    {{-- <form class="d-flex gap-2" action="{{ route('import-sheet1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <input class="form-control" type="file" name="file">
                    </div>
                    <button type="submit" class="btn btn-success">Import</button>
                    </form> --}}
                </div>
            </div>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        <div class="mainTable">
            <div class="container-fluid">
                <div class="bottomTable">
                    <table class="table dataTable">
                        <thead class="">
                            <tr>
                                <th>Casefile Id</th>
                                <th>Barcode</th>
                                <th>Notesontube</th>
                                <th>Ship Destination Type</th>
                                <th>Rack Id</th>
                                <th>Name</th>
                                <th>Closing Notes</th>
                                <th>Closed</th>
                            </tr>
                        </thead>
                        <tbody class="overflow-auto">
                            @foreach ($sheet2Data as $data)
                            <tr>
                                <td>{{ $data->casefile_id }}</td>
                                <td>{{ $data->barcode }}</td>
                                <td>{{ $data->notesontube }}</td>
                                <td>{{ $data->ship_destination_type }}</td>
                                <td>{{ $data->rack_id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->closing_notes }}</td>
                                <td>{{ $data->closed }}</td>
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
