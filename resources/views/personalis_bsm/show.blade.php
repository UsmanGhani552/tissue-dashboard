@extends('layout.master')
@section('content')
<div class="tab-content">


    <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
        <div class="container-fluid current-head">
            <div class="row">
                <div class="col-lg-2">
                    <h2>Total Records</h2>
                </div>
                <div class="col-lg-10 margin-top" style="margin-top:-20px">
                    <form method="GET" action="{{ route('personalis_bsm.show') }}">
                        <div class="row align-items-end">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Search By Name" value="{{ request('name') }}">
                            </div>
                            <div class="col">
                                <label for="">Date</label>
                                <input type="date" name="date" class="form-control" placeholder="Search By Date" value="{{ request('date') }}">
                            </div>
                            <div class="col">
                                <label for="">From</label>
                                <input type="date" name="from_date" class="form-control" placeholder="Search By Date" value="{{ request('from_date') }}">
                            </div>
                            <div class="col">
                                <label for="">To</label>
                                <input type="date" name="to_date" class="form-control" placeholder="Search By Date" value="{{ request('to_date') }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-between">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#letter" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Letter</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#commentor" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Commentor</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#shipped_by" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Shipped By</button>
                    </li>
                </ul>
                <div>
                    <a href="{{ route('personalis_bsm') }}" class="btn btn-primary px-5">Back</a>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="letter" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="mainTable">
                        <div class="container-fluid">
                            <div class="bottomTable">
                                <table class="table dataTable">
                                    <thead class="">
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Count</th>
                                            <th>Ship date</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        @foreach ($letters as $letter)
                                        <tr>
                                            <td>{{ $letter->id }}</td>
                                            <td>{{ $letter->name }}</td>
                                            <td>{{ $letter->count }}</td>
                                            <td>{{ $letter->ship_date }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead class="">
                                        <tr>
                                            <th>Total Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        <tr>
                                            <td>{{ $letterCount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="commentor" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="mainTable">
                        <div class="container-fluid">
                            <div class="bottomTable">
                                <table class="table dataTable">
                                    <thead class="">
                                        <tr>
                                            <th>Id</th>
                                            <th>Commentor</th>
                                            <th>Count</th>
                                            <th>Ship date</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        @foreach ($commentors as $commentor)
                                        <tr>
                                            <td>{{ $commentor->id }}</td>
                                            <td>{{ $commentor->name }}</td>
                                            <td>{{ $commentor->count }}</td>
                                            <td>{{ $commentor->ship_date }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead class="">
                                        <tr>
                                            <th>Total Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        <tr>
                                            <td>{{ $commentorCount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="shipped_by" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="mainTable">
                        <div class="container-fluid">
                            <div class="bottomTable">
                                <table class="table dataTable">
                                    <thead class="">
                                        <tr>
                                            <th>Id</th>
                                            <th>Shipped By</th>
                                            <th>Count</th>
                                            <th>Ship date</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        @foreach ($shippedBys as $shippedBy)
                                        <tr>
                                            <td>{{ $shippedBy->id }}</td>
                                            <td>{{ $shippedBy->name }}</td>
                                            <td>{{ $shippedBy->count }}</td>
                                            <td>{{ $shippedBy->ship_date }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead class="">
                                        <tr>
                                            <th>Total Count</th>
                                        </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                        <tr>
                                            <td>{{ $shippedByCount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    @endsection
