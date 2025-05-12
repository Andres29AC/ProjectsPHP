<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="{{ asset('styles/style.css')}}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="#">
        <svg width="250" height="50" xmlns="http://www.w3.org/2000/svg">
            <style>
            .black { fill:rgb(247, 234, 234); font-family: Arial, sans-serif; font-size: 32px; }
            .pink { fill: #ff7f9f; font-family: Arial, sans-serif; font-size: 32px; }
            </style>
            <text x="10" y="35" class="black">Reserve</text>
            <text x="132" y="35" class="pink">Rooms</text>
        </svg>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarText">
        @auth('admin')
            <ul class="navbar-nav side-nav"  >
            <li class="nav-item">
                <a class="nav-link" style="margin-left: 20px;" href="{{ route('admins.dashboard')}}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
                <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admins.all')}}" style="margin-left: 20px;">
                <i class="fas fa-user-cog"></i> Admins
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hotels.all')}}" style="margin-left: 20px;">
                <i class="fas fa-hotel"></i> Hotels
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rooms.all')}}" style="margin-left: 20px;">
                <i class="fas fa-bed"></i> Rooms
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="bookings-admins/show-bookings.html" style="margin-left: 20px;">
                <i class="fas fa-calendar-check"></i> Bookings
                </a>
            </li>
            </ul>
        @endauth
        <ul class="navbar-nav ml-md-auto d-md-flex">
          @auth('admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admins.dashboard')}}">Home
                <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::guard('admin')->user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
          @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('view.login')}}">login
                </a>
            </li>
          @endauth       
        </ul>
      </div>
    </div>
    </nav>
    <div class="container-fluid">
        <main class = "py-4" >
            @yield('content')
        </main>
    </div>
  </div>
<script type="text/javascript">

</script>
</body>
</html>