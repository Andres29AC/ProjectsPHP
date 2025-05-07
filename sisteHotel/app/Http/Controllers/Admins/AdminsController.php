<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use App\Models\Hotel;
use App\Models\Apartment;
use Illuminate\Support\Facades\Hash;
use Redirect;
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
}
//devcoder89DF


//NOTE - Admin 2:
//REVIEW - andreDev87@gmail.com
//REVIEW - Andre
//REVIEW - reserve98lion