@extends('layout.master')
@section('content')
    <div class="tab-content">
        <div class="tab-pane active link" id="link" role="tabpanel">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Create User</h2>
                    </div>
                    <div class="col-lg-6">
                        <a class="btn btn-primary" href="{{ route('user.index') }}" role="button">Back</a>
                    </div>
                </div>
            </div>
            <div class="formDiv">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="row mainRow">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-2 label">
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
                        <div class="col-6">
                            <div class="row">
                                <div class="col-2 label">
                                    <label for="email" class="form-label" aria-required="true">Email</label>
                                </div>
                                <div class="col input">
                                    <input type="text" name="email" id="email" class="form-control">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mainRow">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-2 label">
                                    <label for="password" class="form-label" aria-required="true">Password</label>
                                </div>
                                <div class="col input">
                                    <input type="password" name="password" id="password" class="form-control">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-2 label">
                                    <label for="password_confirmation" class="form-label" aria-required="true">Confirm Password</label>
                                </div>
                                <div class="col input">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mainRow">
                        <div class="col mt-4">
                            <div class="row">
                                <div class="col-2 label">
                                    <label for="dropdown" class="form-label" aria-required="true">Roles</label>
                                </div>
                                <div>
                                    @foreach ($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" name="roles[]" type="checkbox"
                                                value="{{ $role->id }}" id="role{{ $role->id }}"
                                                style="
                                            height: 18px;
                                            border-radius: 0;
                                        " />
                                            <span class="form-check-label" for="role{{ $role->id }}">
                                                {{ $role->name }}
                                            </span>
                                        </div>
                                    @endforeach
                                    @error('roles')
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
