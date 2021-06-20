@extends('layouts.frontend_layout')
@section('content')

<section id="what-we-do" style="background-color:rgba(247, 244, 244, 0.438); margin-top: 5px;">
   <div class="container" style="box-shadow: 0px 0px 2px 0px gray;background-color:white !important;" >
     <div class="row">
      <div class="col-lg-4 mt-3">
         <img src="team.jpg" class="d-block m-auto" alt="Business Logo" style="max-width: 120px;align-items: center;" >
         <hr>
         <h3 style="text-align: center;" class="mt-3"> Individual Tax Consultation</h2>
         <p  class="d-flex mt-sm-2" style="justify-content: center; align-items: center; text-align: center;">
             <span class="material-icons " style="margin: 3px;">schedule</span>30mins &nbsp;
             <span class="material-icons" style="margin: 3px;">phone</span>Phone Call&nbsp;
         </p>
         <p style="text-align: center;">Are you an individual in need of personal tax prep services? 
              We are here to help. Let's go over your tax prep needs, and get the ball rolling!
         </p>
      </div>

      <div class="col-lg-8 d-block mt-sm-1">
        <h2 class="text-center text-muted  mb-sm-4 mt-3" style="color: rgba(37, 153, 37, 0.699) !important;">Book Appointment</h2>
            <hr>
         <div class="row">
         @foreach ($services as $service)
               <div class="col-sm-6">
                  <a href="{{ route('service.list', $staff->id) }}" title="Read more" class="read-more" >
                     <div class="card">
                        <div class="card-block block-3 m-xs-0">
                           <img src="https://www.seekpng.com/png/detail/65-653408_happy-girl-png-business-girls.png" class="myimg" />   
                           <h3 class="card-title"  style="margin-left: 85px;margin-bottom: 5px;">{{ $service->name }}</h3>
                           <p class="card-text"  style="margin-left: 90px;opacity: .7;margin-bottom: 2px;">{{ $service->description }}</p>
                           <span style="margin-left: 15px;">Book me<i class="fa fa-angle-double-right ml-2"></i></span>
                        </div>
                     </div>
                  </a>
               </div>
            @endforeach
         </div>
      </div>
     </div>
   </div>	
</section>
@stop