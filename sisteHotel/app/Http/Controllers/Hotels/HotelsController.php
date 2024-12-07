<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use DateTime;
use Illuminate\Support\Facades\Auth;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function rooms($id)
    {
        $getRooms = Apartment::select()->orderBy('id', 'desc')->take(6)
            ->where('hotel_id', $id)->get();
        return view('hotels.rooms', compact('getRooms'));
    }
    public function roomDetails($id)
    {
        $roomDetail = Apartment::find($id);
        return view('hotels.roomdetails', compact('roomDetail'));
    }
    // public function roomBooking(Request $request,$id){
    //     $room = Apartment::find($id);
    //     $hotel = Hotel::find($id);
    //     if(date("Y/m/d") < $request->check_in AND date("Y/m/d") < $request->check_out){
    //         $date_check_in = new DateTime($request->check_in);
    //         $date_check_out = new DateTime($request->check_out);
    //         $interval = $date_check_in->diff($date_check_out);
    //         $days = $interval->format('%a');
    //         if($request->check_in < $request->check_out){
    //             $bookRooms = Booking::create([
    //                 "name" => $request->name,
    //                 "email" => $request->email,
    //                 "phone_number" => $request->phone_number,
    //                 "check_in" => $request->check_in,
    //                 "check_out" => $request->check_out,
    //                 "days" => $days,
    //                 "price" => 0,
    //                 "user_id" => Auth::user()->id,
    //                 "room_name" => $room->name,
    //                 "hotel_name" => $hotel->name,
    //             ]);
    //             echo "You booked successfully";
    //         }else{
    //             echo "check out date should be greater than check in date";
    //         }
    //     }else{
    //         echo "Choose dates in the future, invalid check-in or check-out date";
    //     }
    // }
    public function roomBooking(Request $request, $id)
    {
        $room = Apartment::find($id);
        $hotel = Hotel::find($id);

        // Crear objetos DateTime para la fecha actual, check-in y check-out
        $currentDate = new DateTime();
        $checkInDate = new DateTime($request->check_in);
        $checkOutDate = new DateTime($request->check_out);

        // Verificar si las fechas son en el futuro
        if ($checkInDate > $currentDate && $checkOutDate > $currentDate) {
            // Verificar que la fecha de check-out sea posterior a la de check-in
            if ($checkInDate < $checkOutDate) {
                // Calcular los días de estancia
                $interval = $checkInDate->diff($checkOutDate);
                $days = $interval->format('%a');

                // Crear la reserva
                $bookRooms = Booking::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone_number" => $request->phone_number,
                    "check_in" => $request->check_in,
                    "check_out" => $request->check_out,
                    "days" => $days,
                    "price" => 0,  // Puedes agregar el cálculo del precio aquí
                    "user_id" => Auth::user()->id,
                    "room_name" => $room->name,
                    "hotel_name" => $hotel->name,
                ]);
                echo "You booked successfully";
            } else {
                echo "Check-out date should be greater than check-in date.";
            }
        } else {
            echo "Choose dates in the future, invalid check-in or check-out date.";
        }
    }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
