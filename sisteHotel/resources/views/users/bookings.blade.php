@extends('layouts.app')

@section('content')
    <div class="hero-wrap js-fullheight" style="margin-top: -25px;background-image: url('{{asset('images/room-1.jpg')}}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h1 class="subheading">My Bookings</h1>
                    <h1 class="mb-4"></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5 ">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Check-In</th>
                        <th scope="col">Check-Out</th>
                        <th scope="col">Days</th>
                        <th scope="col">Price</th>
                        <th scope="col">Room Name</th>
                        <th scope="col">Hotel Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->phone_number }}</td>
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td>{{ $booking->days }}</td>
                            <td>${{ number_format($booking->price, 2) }}</td>
                            <td>{{ $booking->room_name }}</td>
                            <td>{{ $booking->hotel_name }}</td>
                            <td>
                                <span class="badge 
                                    @if($booking->status === 'Confirmed') bg-success 
                                    @elseif($booking->status === 'Pending') bg-warning 
                                    @else bg-danger 
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
