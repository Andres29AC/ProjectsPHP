
@extends('layouts.admin')
@section('content')
<div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <i class="fas fa-hotel"></i> Hotels
              </h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">Number of hotels: {{$hotelsCount}}</p>
             
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <i class="fas fa-bed"></i> Rooms
              </h5>
              
              <p class="card-text">Number of rooms: {{ $roomsCount}}</p>
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <i class="fas fa-user-cog"></i> Admins
              </h5>
              
              <p class="card-text">Number of admins: {{ $adminsCount}}</p>
              
            </div>
          </div>
        </div>
      </div>

@endsection