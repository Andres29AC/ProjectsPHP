@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
           <div class="card-body">
              <div class="container">
                @if (session()->has('success'))
                  <div class="alert alert-success">
                    {{ session()->get('success') }}
                  </div>
                @endif
              </div>
              <div class="container">
                @if (session()->has('delete'))
                  <div class="alert alert-danger">
                    {{ session()->get('delete') }}
                  </div>
                @endif
              </div>
              <h5 class="card-title mb-4 d-inline">Rooms</h5>
             <a  href="{{ route('rooms.create')}}" class="btn btn-primary mb-4 text-center float-right">Create Room</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">image</th>
                    <th scope="col">price</th>
                    <th scope="col">num of persons</th>
                    <th scope="col">size</th>
                    <th scope="col">view</th>
                    <th scope="col">num of beds</th>
                    <th scope="col">hotel id</th>
                    <!-- <th scope="col">status value</th>
                    <th scope="col">change status</th> -->
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rooms as $room)  
                  <tr>
                    <th scope="row">{{ $room->id }}</th>
                    <td>{{ $room->name }}</td>
                    <td><img src="{{ asset('images/'.$room->image.'') }}" alt="Room Image" style="width: 100px; height: 100px;"></td>
                    <td>${{ $room->price }}</td>
                    <td>{{ $room->max_persons }}</td>
                    <td>{{ $room->size }} m<sup>2</sup></td>
                    <td>{{ $room->view }}</td>
                    <td>{{ $room->num_beds }}</td>
                    <td>{{ $room->hotel_id }}</td>
                    <!-- <td>1</td>

                    <td><a href="status.html" class="btn btn-danger  text-center ">status</a></td> -->
                    <td><a href="{{ route('rooms.delete',$room->id) }}" class="btn btn-danger  text-center ">Delete</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table> 
            </div>
        </div>
    </div>
</div>
@endsection
