@extends('layouts/contentNavbarLayout')

@section('title', 'Actuator - Details & Nodes')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.2/mqttws31.min.js" type="text/javascript"></script>
<script src="{{asset('js/mqtt.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js" integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
      $(function() {

        $('.operation').change(function() {
            var pump = $(this).data('id'); 
            var mode = $(this).prop('checked') == true ? 1 : 0; 
            console.log(mode, pump);

            var m = mode==1 ? "true":"false";
            var p = pump==1 ? "true":"false";

            msg = '{"pump": "'+p+'", "operationMode": "'+m+'"}';
            
            console.log(msg);

            if (mode = 1) {
              document.getElementById('flexSwitchCheckCheckedPump').disabled = $(this).prop('checked');
            }else {
              document.getElementById('flexSwitchCheckCheckedPump').disabled = $(this).prop('checked');
            }

            publishMessage(msg);
        });

        $('.pumpp').change(function() {
            var mode = $(this).data('id'); 
            var pump = $(this).prop('checked') == true ? 1 : 0; 
            // console.log(mode, pump);

            var m = mode==1 ? "true":"false";
            var p = pump==1 ? "true":"false";

            $.ajax({
                type: "GET",
                // dataType: "json",
                url: '{{ route("get_mode") }}',
                // data: {'pumpStatus': pump, 'modeStatus': mode},
                success: function(data){
                  // console.log(data)
                  var m = data==1 ? "true":"false";
                  msg = '{"pump": "'+p+'", "operationMode": "'+m+'"}';
                  publishMessage(msg);
                  console.log(msg);
                }
            });

            

        });

      })

  </script>

@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Actuator /</span> {{$actuator->name}} / Info
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">{{$actuator->name}} Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-5">
          {{-- <img src="{{asset('assets/img/avatars/1.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" /> --}}
          <div class="button-wrapper ml-5">
            <p class="text mb-0">This actuator covers {{count($nodes)}} nodes and it's <span class="badge bg-label-primary me-1">Active</span></p>
            <p class="text mb-0">Device ID : {{$actuator->device_id}}</p>
            <br>
            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalCenter">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Add node</span>
            </button>
            <button type="button" class="btn btn-outline-secondary account-image-reset" data-bs-toggle="modal" data-bs-target="#modalReset">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>
            <div class="form-check form-switch mt-3">
              <input class="form-check-input operation"  type="checkbox" role="switch" id="flexSwitchCheckCheckedMode" data-id="{{$s_status->pump}}" {{$s_status->mode ==1 ? "checked":" "}}>
              <label class="form-check-label" for="flexSwitchCheckCheckedMode">Automatic Mode</label>
            </div>
            {{-- <mode-vue device_id="{{$actuator->device_id}}" mode="{{$s_status->mode}}" pump="{{$s_status->pump}}" /> --}}
            </div>
          </div>
          <div class="button-wrapper ">
            <div class="form-check form-switch">
              <input class="form-check-input pumpp" type="checkbox" role="switchf" id="flexSwitchCheckCheckedPump" data-id="{{$s_status->mode}}" {{$s_status->pump==1 ? "checked":" "}}>
              <label class="form-check-label" for="flexSwitchCheckCheckedPump">Water Pump</label>
            </div>
            {{-- <pump-vue device_id="{{$actuator->device_id}}" mode="{{$s_status->mode}}" pump="{{$s_status->pump}}" /> --}}
          </div>
      </div>
      <hr class="my-0">
      
      <h6 class="card-header">Nodes List</h6>
      <div class="table-responsive text-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Node No.</th>
          <th>Name</th>
          <th>status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
          @if (count($nodes)>0)
            @foreach ($nodes as $n)  
            <tr>
              <td>{{$n->num ?? "Not connected"}}</td>
              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$n->name}}</strong></td>
              <td>
                  <span class="badge bg-label-primary me-1">Connected (Live)</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu" style="position: relative; z-index:99999999;">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> View live</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalupdatenode{{$n->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="{{ route('delete_node', ['node'=>$n->id]) }}" onclick="event.preventDefault(); 
                    if(confirm('Are you sure you want to delete this node ({{$n->name}})\nEither OK or Cancel.')){document.getElementById('logout-form{{$n->id}}').submit();}"><i class="bx bx-trash me-1"></i> Delete</a>
                    <form id="logout-form{{$n->id}}" action="{{ route('delete_node', ['node'=>$n->id]) }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            {{-- reset device --}}
    <div class="modal fade" id="modalupdatenode{{$n->id}}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="updateformnode{{$n->id}}" action="{{route('update_node', ['node'=>$n->id])}}" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalCenterTitle">Update Node</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                    @csrf
                    <div class="col-12">
                        <label for="nameWithTitle" class="form-label">Name</label>
                        <input type="text" id="nameWithTitle" value="{{$n->name}}" required name="name" class="form-control" placeholder="Enter Name">
                    </div>
                    <div class="col-12">
                        <label for="nameWithTitle" class="form-label">Node Number</label>
                  <input type="text" id="nameWithTitle" name="num" required value="{{$n->num}}" class="form-control" placeholder="Enter the number on the node device">
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" onclick="event.preventDefault(); document.getElementById('updateformnode{{$n->id}}').submit();" class="btn btn-primary">Update</button>
                {{-- <input value="Update" type="submit"> --}}
              </div>
            </div>
        </form>
      </div>
    </div>
            @endforeach
          @else
          <tr>
              <td colspan="5" align="center">No nodes found! <a href="#" data-bs-toggle="modal" data-bs-target="#modalCenter">Add One</a></td>
          </tr>
          @endif
      </tbody>
    </table>
  </div>
    </div>
    
  </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="{{route('store_node', ['actuator'=>$actuator->id])}}" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Create Node</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <label for="nameWithTitle" class="form-label">Name</label>
                  <input type="text" id="nameWithTitle" name="name" class="form-control" placeholder="Enter Name">
                  <br>
                  <label for="nameWithTitle" class="form-label">Node Number</label>
                  <input type="text" id="nameWithTitle" name="num" class="form-control" placeholder="Enter the number on the node device">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    {{-- reset device --}}
    <div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="{{route('reset_actuator', ['actuator'=>$actuator->id])}}" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Reset Actuator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-12">
                        <label for="idWithTitle" class="form-label">Device Id</label>
                        <input type="text" id="idWithTitle" name="device_id" class="form-control" placeholder="Enter device Id">
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Reset</button>
              </div>
            </div>
        </form>
      </div>
    </div>
@endsection
