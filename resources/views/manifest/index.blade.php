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
                      <form class="d-flex gap-2" action="{{ route('import-manifest') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div>
                              <input class="form-control" type="file" name="file">
                          </div>
                          <button type="submit" class="btn btn-success">Import</button>
                      </form>
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
                                <th>Id</th>
                                <th>Sheet Id</th>
                                <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody class="overflow-auto">
                              @foreach ($manifests as $manifest)
                              <tr>
                                  <td>{{ $manifest->id }}</td>
                                <td>{{ $manifest->name }}</td>

                                  <td>
                                      <div class="dropdown open">
                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown">
                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                  <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z" />
                                              </svg>
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="triggerId">
                                          <a class="dropdown-item" href="{{ route('manifest-show', $manifest->id) }}">Show</a>
                                              <a class="dropdown-item" href="{{ route('manifest-delete', $manifest->id) }}">Delete</a>
                                          </div>
                                      </div>
                                      <!-- <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/></svg></button> -->
                                  </td>
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
