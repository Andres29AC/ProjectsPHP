<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use App\Models\Hotel;
use App\Models\Apartment;
use Illuminate\Support\Facades\Hash;
use Redirect;
use File;
class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view('admins.login');
    }
    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            return redirect()->route('admins.dashboard');
        } 
        return redirect()->back()->with('error', 'Error in login');
    }
    public function index()
    {
        $adminsCount = Admin::select()->count();
        $hotelsCount = Hotel::select()->count();
        $roomsCount = Apartment::select()->count();
        return view('admins.index', compact('adminsCount', 'hotelsCount', 'roomsCount'));
    }
    public function allAdmins()
    {
        $admins = Admin::select()->orderBy('id', 'desc')->get();

        return view('admins.alladmins', compact('admins'));
    }
    public function createAdmins()
    {
        return view('admins.createadmins');
    }
    public function storeAdmins(Request $request)
    {
        $storeAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($storeAdmins) {
            return Redirect()->route('admins.all')->with('success', 'Admin created successfully');
        } else {
            return Redirect()->back()->with('error', 'Error in creating admin');
        }
    }
    public function allHotels()
    {
        $hotels = Hotel::select()->orderBy('id', 'desc')->get();
        return view('admins.allhotels', compact('hotels'));
    }
    public function createHotels()
    {
        return view('admins.createhotels');
    }
    public function storeHotels(Request $request)
    {
        Request()->validate([
            'name' => 'required|max:40',
            'image' => 'required|mimes:jpg,jpeg,png|max:888',
            'description' => 'required',
            'location' => 'required|max:40',
        ]);
        $destinationPath = 'images/';
        $myImage = $request->image ->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myImage);

        $storeHotels = Hotel::create([
            'name' => $request->name, 
            'image' => $myImage,
            'description' => $request->description,
            'location' => $request->location,
        ]);
        if ($storeHotels) {
            return Redirect()->route('hotels.all')->with('success', 'Hotel created successfully');
        }
    }
    public function editHotels(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        return view('admins.edithotels', compact('hotel'));
    }
    // public function updateHotels(Request $request, $id)
    // {
    //     Request()->validate([
    //         'name' => 'required|max:40',
    //         'description' => 'required',
    //         'location' => 'required|max:40',
    //     ]);
    //     $hotel = Hotel::find($id);
    //     $hotel->update($request->all());
    //     if($hotel){
    //         return Redirect()->route('hotels.all')->with('update', 'Hotel updated successfully');
    //     }
    // }
    public function updateHotels(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:40',
            'description' => 'required',
            'location' => 'required|max:40',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $hotel = Hotel::findOrFail($id);

        $hotel->name = $request->name;
        $hotel->description = $request->description;
        $hotel->location = $request->location;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $hotel->image = $imageName;
        }

        $hotel->save();

        return redirect()->route('hotels.all')->with('update', 'Hotel updated successfully');
    }
    public function deleteHotels(Request $request, $id)
    {
        // $hotel = Hotel::find($id);
        // if(File::exists(public_path('images/'.$hotel->image))){
        //     File::delete(public_path('images/'.$hotel->image));
        // }
        // $hotel->delete();
        // if($hotel){
        //     return Redirect()->route('hotels.all')->with('delete', 'Hotel deleted successfully');
        // }
        $hotel = Hotel::find($id);
        if ($hotel) {
            $hotel->delete();
            return Redirect()->route('hotels.all')->with('delete', 'Hotel deleted successfully');
        } else {
            return Redirect()->back()->with('error', 'Error in deleting hotel');
        }
    }
    public function allRooms()
    {
        $rooms = Apartment::select()->orderBy('id', 'desc')->get();
        return view('admins.allrooms', compact('rooms'));
    }


}
//devcoder89DF


//NOTE - Admin 2:
//REVIEW - andreDev87@gmail.com
//REVIEW - Andre
//REVIEW - reserve98lion