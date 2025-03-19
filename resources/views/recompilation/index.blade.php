  @extends('layout.master')
  @section('content')
      <div class="tab-content">

          <div class="tab-pane active" id="currentweek" role="tabpanel" aria-labelledby="currentweek-tab">
            <div class="container-fluid current-head">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Rack Ids</h2>
                    </div>
                    <div class="col-lg-6">
                        <a id="" class="btn green" href="{{ route('recompile.export') }}" role="button">Export
                        </a>
                    </div>
                </div>
            </div>
             
              @if (session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
              @endif
              
              
              <div class="mainTable mt-2">
                  <div class="container-fluid">
                      <div class="bottomTable">
                          <table class="table">
                              <thead class="">
                                  <tr>
                                      <th>Submitter Id</th>
                                      <th>Rack Id</th>
                                      <th>CaseFile Id</th>
                                  </tr>
                              </thead>
                              <tbody class="overflow-auto">
                                  @if (count($results) > 0)
                                      @foreach ($results as $result)
                                          <tr>
                                              <td>{{ $result['submitter_id'] }}</td>
                                              <td>{{ $result['rack_id'] }}</td>
                                              <td>{{ $result['casefile_id'] }}</td>
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
