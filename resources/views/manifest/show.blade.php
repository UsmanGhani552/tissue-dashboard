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
                                <th>Submitter Id</th>
                                <th>vendir</th>
                                <th>Received</th>
                                <th>Checked Out</th>
                                <th>Letter</th>
                                <th>Commentor</th>
                                <th>Comment</th>
                                <th>Shipped By</th>
                                <th>Tracking</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="overflow-auto">
                            @foreach ($manifestData as $data)
                            <tr>
                                <td>{{ $data->submitter_id }}</td>
                                <td>{{ $data->vendor_id }}</td>
                                <td>{{ $data->received }}</td>
                                <td>{{ $data->checked_out }}</td>
                                <td>{{ $data->letter }}</td>
                                <td>{{ $data->commentor }}</td>
                                <td>{{ $data->comment }}</td>
                                <td>{{ $data->shipped_by }}</td>
                                <td>{{ $data->tracking }}</td>
                                <td>{{ $data->date }}</td>
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
