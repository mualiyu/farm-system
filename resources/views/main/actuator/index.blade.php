@extends('layouts/contentNavbarLayout')

@section('title', 'Actuators - list')

@section('page-script')
<script src="{{asset('assets/js/ui-modals.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Actuator /</span> List
  <button style="float: right;" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#modalCenter">Add New</button>
</h4>

<!-- Basic Bootstrap Table -->
<div class="card" >
  <h5 class="card-header">Actuators</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>DeviceId</th>
          <th>No. of Nodes</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
          @if (count($actuators)>0)
            @foreach ($actuators as $a)  
            <tr>
              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$a->name}}</strong></td>
              <td>{{$a->device_id ?? "Not connected"}}</td>
              <td>
                {{count($a->nodes)}}
              </td>
              <td>
                  @if ($a->value == 1)
                    <span class="badge bg-label-primary me-1">Active</span></td>
                  @else
                    <span class="badge bg-label-warning me-1">Inactive</span>
                  @endif
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu" style="position: relative; z-index:99999999;">
                    <a class="dropdown-item" href="{{route('actuator', ['actuator'=>$a->id])}}"><i class="bx bx-edit-alt me-1"></i> View</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          @else
          <tr>
              <td colspan="5" align="center">No Actuators found! <a href="#" data-bs-toggle="modal" data-bs-target="#modalCenter">Add One</a></td>
          </tr>
          @endif
        
      </tbody>
    </table>
  </div>
</div>
<!--/ Basic Bootstrap Table -->
<!-- Vertically Centered Modal -->

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{route('store_actuator')}}" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Create Actuator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row g-2">
                    <div class="col mb-0">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="nameWithTitle" name="name" class="form-control" placeholder="Enter Name">
                    </div>
                  <div class="col mb-0">
                    <label for="emailWithTitle"  class="form-label">Device Id <small>(optional)</small></label>
                    <input type="text" id="emailWithTitle" name="device_id" class="form-control" placeholder="The No. on the Device">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
        </form>
      </div>
    </div>
@endsection
