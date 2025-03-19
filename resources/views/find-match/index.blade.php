  @extends('layout.master')
  @section('content')
      <div class="tab-content">


          <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
              <div class="container-fluid current-head">
                  <div class="row">
                      <div class="col-lg-6">
                          <h2>Percentage of matched records</h2>
                      </div>

                      <div class="col-lg-6">
                          {{ $matchedPercentage }}%
                      </div>
                  </div>
              </div>
              @if (session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
              @endif
              <h2>Manifest Table</h2>

              <div class="mainTable">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      {{-- <th>Id</th> --}}
                                      <th>Submitter Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  @if (count($extraRecordsA) > 0)
                                      @foreach ($extraRecordsA as $recordsA)
                                          <tr>
                                              {{-- <td>{{ $recordsA->id }}</td> --}}
                                              <td>{{ $recordsA['submitter_id'] }}</td>
                                          </tr>
                                      @endforeach
                                  @else
                                      <tr>
                                        <td>No Mismatch Record</td>

                                      </tr>
                                  @endif
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <h2>Receiving Table</h2>
              <div class="mainTable mt-2">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      {{-- <th>Id</th> --}}
                                      <th>Submitter Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  @if (count($extraRecordsB) > 0)
                                      @foreach ($extraRecordsB as $recordsB)
                                          <tr>
                                              {{-- <td>{{ $recordsB->id }}</td> --}}
                                              <td>{{ $recordsB['submitter_id'] }}</td>
                                          </tr>
                                      @endforeach
                                  @else
                                      <tr>
                                        <td>
                                            No Mismatch Record
                                        </td>
                                      </tr>
                                  @endif
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              
          </div>

      </div>
  @endsection
