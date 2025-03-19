@extends('layout.master')
@section('content')
    <div class="tab-content">
        <div class="tab-pane active link" id="link" role="tabpanel">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Create Role</h2>
                    </div>
                    <div class="col-lg-6">
                        <a class="btn btn-primary" href="{{ route('role.index') }}" role="button">Back</a>
                    </div>
                </div>
            </div>
            <div class="formDiv">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="row mainRow">

                        <div class="col-12">
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
                    <div class="row mainRow">
                        <div class="col">
                            <div class="row">
                                <div class="col-1 label">
                                    <label for="dropdown" class="form-label" aria-required="true">Permissions</label>
                                </div>
                                <div class="row pl-5">
                                    @foreach ($permissions as $index =>  $permission)
                                        <div class="form-check col-md-3">
                                            <input class="form-check-input" name="permissions[]" type="checkbox"
                                                value="{{ $permission->id }}" id="role{{ $permission->id }}"
                                                style="
                                            height: 18px;
                                            border-radius: 0;
                                        " />
                                            <span class="form-check-label" for="role{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </span>
                                        </div>
                                    @endforeach
                                    @error('permissions')
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
