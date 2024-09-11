<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidebar">
   <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{action([\App\Http\Controllers\BillingController::class, 'index'])}}">
         <img src="/assets/img/logo.png" class="navbar-brand-img mx-auto" alt="Back to dashboard...">
      </a>
      <div class="navbar-user d-md-none">
         <div class="dropdown">
            <a href="#!" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <div class="avatar avatar-sm avatar-online">
                  <img src="/assets/img/alec.png" class="avatar-img rounded-circle" alt="...">
               </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
               <a href="/portal/profile" class="dropdown-item">{{utrans("nav.profile")}}</a>
               <hr class="dropdown-divider">
               <a href="/logout" class="dropdown-item">{{utrans("nav.logOut")}}</a>
            </div>
         </div>
      </div>

      <div class="collapse navbar-collapse" id="sidebarCollapse">
         <!-- Customer Portal Sidebar-->
         <h6 class="navbar-heading text-muted mt-4">
            {{utrans("nav.myService")}}
         </h6>
         <ul class="navbar-nav">
            <li class="nav-item">
               <a @if(str_contains(Route::getCurrentRoute()->uri(),"billing")) class="nav-link selected" @else class="nav-link" @endif href="{{action([\App\Http\Controllers\BillingController::class, 'index'])}}">
               <i class="fe fe-dollar-sign"></i> {{utrans("nav.billing")}}</a>
            </li>
            @if(config("customer_portal.ticketing_enabled") === true)
            <li class="nav-item">
               <a @if(str_contains(Route::getCurrentRoute()->uri(),"tickets")) class="nav-link selected" @else class="nav-link" @endif href="{{action([\App\Http\Controllers\TicketController::class, 'index'])}}">
               <i class="fe fe-message-circle"></i> {{utrans("nav.tickets")}}</a>
            </li>
            @endif
         </ul>
         <h6 class="navbar-heading text-muted mt-4">
            {{utrans("nav.myAccount")}}
         </h6>
         <ul class="navbar-nav">
            <li class="nav-item">
               <a @if(str_contains(Route::getCurrentRoute()->uri(),"profile")) class="nav-link selected" @else class="nav-link" @endif href="{{action([\App\Http\Controllers\ProfileController::class, 'show'])}}">
               <i class="fe fe-users"></i> {{utrans("nav.profile")}}</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/logout">
               <i class="fe fe-log-out"></i> {{utrans("nav.logOut")}}</a>
            </li>
         </ul>
         
         <div class="navbar-user mt-auto d-none d-md-flex align-items-center">
            <div class="avatar avatar-sm avatar-online">
               <img src="/assets/img/alec.png" class="avatar-img rounded-circle" alt="Profile Image">
            </div>

            <span class="ml-2">{{ $contact->getName() }}</span>

            <div class="dropup ml-auto">
               <a href="#sidebarDropup" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fe fe-chevron-up"></i>
               </a>
               <div id="sidebarDropup" class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                  <a href="/portal/profile" class="dropdown-item">{{ utrans("nav.profile") }}</a>
                  <hr class="dropdown-divider">
                  <a href="/logout" class="dropdown-item">{{ utrans("nav.logOut") }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</nav>
