<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use DateTime;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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
    public function roomBooking(Request $request, $id)
    {
        $room = Apartment::find($id);
        $hotel = Hotel::find($id);

        $currentDate = new DateTime();
        $checkInDate = new DateTime($request->check_in);
        $checkOutDate = new DateTime($request->check_out);

        if ($checkInDate > $currentDate && $checkOutDate > $currentDate) {
            if ($checkInDate < $checkOutDate) {

                $interval = $checkInDate->diff($checkOutDate);
                $days = $interval->format('%a');

                $bookRooms = Booking::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone_number" => $request->phone_number,
                    "check_in" => $request->check_in,
                    "check_out" => $request->check_out,
                    "days" => $days,
                    "price" => 0,  
                    "user_id" => Auth::user()->id,
                    "room_name" => $room->name,
                    "hotel_name" => $hotel->name,
                ]);
                $totalPrice = $days * $room->price;
                $bookRooms->price = $totalPrice;
                $bookRooms->save();
                Session::put('price', $totalPrice);

                //$price = Session::put('price', $totalPrice);
                //$getPrice = Session::get($price);
                return Redirect::route('hotel.payment');
            } else {
                return Redirect::route('hotel.rooms.details',$room->id)->with(['error' => 'Check out date should be greater than check in date']);
            }
        } else {
            return Redirect::route('hotel.rooms.details',$room->id)->with(['error_dates' => 'Choose dates in the future,invalid check in or check out dates']);
        }
    }
    public function payWithPaypal(){
        $paypalClientId = config('payment.paypal.client_id');
        return view('hotels.payment', compact('paypalClientId'));
    }
    public function success(){
        Session::forget('price'); //NOTE - Para limpiar información temporal como datos de pago o procesos
        return view('hotels.success');
    }
}

