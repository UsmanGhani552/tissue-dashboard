@extends('layout.master')
@section('content')
    <div class="tab-content">
        <div class="tab-pane active link" id="link" role="tabpanel">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Create Permission</h2>
                    </div>
                    <div class="col-lg-6">
                        <a class="btn btn-primary" href="{{ route('permission.index') }}" role="button">Back</a>
                    </div>
                </div>
            </div>
            <div class="formDiv">
                <form action="{{ route('permission.store') }}" method="POST">
                    @csrf
                    <div class="row mainRow">
                        {{-- <div class="col-6">
                            <div class="row">
                                <div class="col-3 label">
                                    <label for="dropdown" class="form-label" aria-required="true">LGA</label>
                                </div>
                                <div class="col input">
                                    <select class="form-select" aria-label="Default select example" name="lga">
                                        <div id="lga">
                                            <option selected disabled>Choose Lga</option>
                                            <option value="ajr">AJR</option>
                                            <option value="bdy">BDY</option>
                                            <option value="epe">EPE</option>
                                            <option value="lkd">LKD</option>
                                            <option value="ifk">LFK</option>
                                            <option value="alm">ALM</option>
                                            <option value="ojo">OJO</option>
                                            <option value="xxx">XXX</option>
                                        </div>
                                    </select>
                                    @error('lga')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div> --}}
                        <div class="col">
                            <div class="row">
                                <div class="col-1 label">
                                    <label for="name" class="form-label" aria-required="true">Name</label>
                                </div>
                                <div class="col input">
                                    <input type="text" name="name" id="name" class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Submit Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection

