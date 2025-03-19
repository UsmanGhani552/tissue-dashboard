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
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    <div class="row mainRow">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1 label">
                                    <label for="name" class="form-label" aria-required="true">Name</label>
                                </div>
                                <div class="col input">
                                    <input type="text" name="name" value="{{ $role->name }}" id="name"
                                        class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col mt-4">
                            <div class="row">
                                <div class="col-1 label">
                                    <label for="dropdown" class="form-label" aria-required="true">Permissions</label>
                                </div>
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" name="permissions[]" type="checkbox"
                                                value="{{ $permission->id }}" id="role{{ $permission->id }}"
                                                style="
                                            height: 18px;
                                            border-radius: 0;"
                                            {{ in_array($permission->id , $role_permissions) ? 'checked' : '' }}
                                            />
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
