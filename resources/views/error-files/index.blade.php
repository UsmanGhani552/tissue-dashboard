@extends('layout.master')
@section('content')
<div class="tab-content">


    <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
        <div class="container-fluid current-head">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Error Files</h2>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('retry') }}" class="btn btn-danger">Retry</a>
                </div>
              
            </div>
        </div>
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
