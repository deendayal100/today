<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
     
      <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
      <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">

      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title> Spot </title>
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
      <link href="{{asset('assets/css/calendar.min.css')}}" rel="stylesheet" type="text/css">
   </head>

   <body>
  
      <!-- header -->
      <header>
         <!-- navigation -->
         <nav class="navbar loginNav navbar-expand-xl navbar-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('assets/images/logo.svg')}}"></a>
            <a href="{{url('/signin')}}" class="btn btn-primary d-xl-none ms-auto me-2 me-lg-5">Sign In / Sign Up</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                     <a class="nav-link" id="my-offers" aria-current="page" href="{{url('my-offers')}}">My Offers</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="subscriptions" href="{{url('subscriptions')}}">Subscriptions</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="hotspot-updates" href="{{url('hotspot-updates')}}">Hotspot Updates</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="report-management" href="{{url('report-management')}}">Report Management</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="community-reviews" href="{{'community-reviews'}}">Community Reviews</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="contact-us" href="{{url('contact-us')}}">Contact Us</a>
                  </li>
               </ul>
                @if(Session::has('id'))
                <div class="nav-right d-none d-xl-block">
                     <a href="#" class="me-4"><span class="icon-notifications d-flex align-items-center justify-content-center"></span></a>
                     <a href="{{route('my_account')}}" class="Nav-profile">

                        <img src="{{Session::get('image')}}">

                     </a>
                  </div>
               @else

               <div class="nav-right d-none d-xl-block">
                  <a href="{{url('signin')}}" id="login" class="btn btn-primary px-4">Sign In / Sign Up</a>
               </div>
            @endif
            </div>
         </div>
         </nav>
      </header>
      