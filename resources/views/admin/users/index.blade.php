@extends('layout.master')
@section('content')
    <div class="tab-content">
        <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Users</h2>
                    </div>
                    <div class="col-lg-6">
                        @can('User create')
                        <a id="" class="btn btn-primary" href="{{ route('user.create') }}" role="button">Add
                            User</a>
                            @endcan
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
                        <table class="table" id="mainTable">
                            <thead class="">
                                <tr>
                                    <th class="text-start">Name</th>
                                    <th class="text-start">Email</th>
                                    <th class="text-start">Role</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            @can('User access')
                            <tbody class="overflow-auto">
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="text-start">{{ $user->name }}</td>
                                        <td class="text-start">{{ $user->email }}</td>
                                        <td class="text-start">
                                            <ul class="p-0">
                                                <li class="list-unstyled">
                                                    @foreach ($user->roles as $role)
                                                        <div class="badge bg-primary">
                                                            {{ $role->name }}
                                                        </div>
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown open">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="triggerId" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <path
                                                            d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z" />
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    @can('User edit')
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.edit', $user->id) }}">Edit</a>
                                                        @endcan
                                                        @can('User delete')
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.delete', $user->id) }}">Delete</a>
                                                        @endcan
                                                </div>
                                            </div>
                                            <!-- <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/></svg></button> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @endcan
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
