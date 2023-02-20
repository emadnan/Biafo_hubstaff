@php
$permission_roles = session()->get('permission_roles_array');
@endphp
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <!-- <a class="nav-item nav-link" href="{{ route('home') }}">Home </a> -->
         @if(isset($permission_roles['Read_Type'])||Auth::user()->user_type=="super_admin")
         <a class="nav-item nav-link" href="{{ route('category') }}">Types</a>
            @endif
            @if(isset($permission_roles['Read_Sector'])||Auth::user()->user_type=="super_admin")
         <a class="nav-item nav-link" href="{{ route('sector') }}">Sectors</a>
            @endif
            @if(isset($permission_roles['Read_Policy'])||Auth::user()->user_type=="super_admin")
         <a class="nav-item nav-link" href="{{ route('policy') }}">Policies</a>
        @endif
        @if(isset($permission_roles['Read_Department'])||Auth::user()->user_type=="super_admin")
         <a class="nav-item nav-link" href="{{ route('department') }}">Departments</a>
            @endif
            @if(isset($permission_roles['Read_Client_Company']))
         <a class="nav-item nav-link" href="{{ route('client_companies') }}">Companies</a>
            @endif
            @if(isset($permission_roles['Read_Subject'])||Auth::user()->user_type=="super_admin")
         <a class="nav-item nav-link" href="{{ route('subject') }}">Subjects</a>
            @endif
            @if(Auth::user()->user_type=="super_admin")

         <a class="nav-item nav-link" href="{{ route('subscription') }}">Subscriptions</a>
            @endif
            @if(Auth::user()->user_type=="super_admin" || Auth::user()->user_type=="company_admin")
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                     data-bs-toggle="dropdown" aria-expanded="false">
                     Reports
                 </a>
                 <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                    @if(Auth::user()->user_type=="super_admin")
                     <li><a class="dropdown-item" href="/companies_reports">Companies Reports</a></li>
                     @endif
                     @if(Auth::user()->user_type=="company_admin")
                     <li><a class="dropdown-item" href="/departments_reports">Departments Reports</a></li>
                    @endif
                 </ul>
         </ul>
     </div>
     @endif

     </ul>
    @if(Auth::user()->user_type=="super_admin"||isset($permission_roles['Read_User'])||isset($permission_roles['Read_Team']))
     <div class="collapse navbar-collapse" id="navbarNavDropdown">
         <ul class="navbar-nav">
             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                     data-bs-toggle="dropdown" aria-expanded="false">
                     Users
                 </a>
                 <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                     @if(isset($permission_roles['Read_User']))
                     <li><a class="dropdown-item" href="{{ route('users') }}">Register a Employee</a></li>
                     @endif
                        @if(Auth::user()->user_type=="super_admin")
                     <li>
                         <a class="dropdown-item" href="{{ route('registercompany') }}">Register Clients</a>
                     </li>

                     <li><a class="dropdown-item" href="{{ route('user_roles') }}">Roles</a></li>
                     <li><a class="dropdown-item" href="/permissions">Permissions</a></li>
                    @endif
                    @if(isset($permission_roles['Read_Team']))
                     <li><a class="dropdown-item" href="{{ route('teams') }}">Teams</a></li>
                    @endif
                 </ul>
             </li>
         </ul>
     </div>
        @endif
        

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->
         <li class="nav-item">
             <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                 <i class="fas fa-search"></i>
             </a>
             <div class="navbar-search-block">
                 <form class="form-inline">
                     <div class="input-group input-group-sm">
                         <input class="form-control form-control-navbar" type="search" placeholder="Search"
                             aria-label="Search">
                         <div class="input-group-append">
                             <button class="btn btn-navbar" type="submit">
                                 <i class="fas fa-search"></i>
                             </button>
                             <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </li>
         <?php /*
         <!-- <div class="collapse navbar-collapse" id="Notifications">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="Notifications" role="button" data-bs-toggle="dropdown" aria-expanded="true">
            <i class="fas fa-bell"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="Notifications">
              @if(Auth::user()->user_type=='super_admin')
            @foreach (auth()->user()->unreadnotifications as $notification)
              <li><a class="dropdown-item" href="{{route('notification')}}"><strong>{{ $notification->data['user_name'] }}</strong> has requested<br> for
                                                <strong>{{ $notification->data['file_name'] }}.</strong></a></li>
            @endforeach
            @endif
            @if(Auth::user()->user_type=='company_admin')
            @foreach (auth()->user()->unreadnotifications as $notification)
              <li><a class="dropdown-item" href="{{route('notification')}}">Dear,<strong>{{ $notification->data['user_name'] }}</strong> your Request<br> for
                                                <strong>{{ $notification->data['file_name'] }}.</strong> accepted</a></li>
            @endforeach
            @endif

            </ul>
          </li>
        </ul>
      </div> -->
      */ ?>
         <!-- Notifications -->
         <style>
         .badge_n {
             position: absolute;
             top: -1px;
             right: -2px;
             padding: 3px 3px;
             border-radius: 25%;
             background-color: red;
             color: white;
         }
         </style>
         <li class="nav-item dropdown">
             <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                 <i class="fas fa-bell"></i>
                 <span class="badge bg-danger count"></span>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifications">



                 <a href="{{route('notification')}}" class="dropdown-item dropdown-footer">See All Notifications</a>
             </div>
         <li class="nav-item">
             <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                 <i class="fas fa-th-large"></i>
             </a>
             @guest
             @if (Route::has('login'))
         <li class="nav-item">
             <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
         </li>
         @endif

         @if (Route::has('register'))
         <li class="nav-item">
             <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
         </li>
         @endif
         @else
         <li class="nav-item dropdown">
             <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false" v-pre>
                 {{ Auth::user()->name }}
             </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('home') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>&nbsp;
                {{ __('Dashboard') }}
            </a>
            <a class="dropdown-item" href="{{ route('change_password') }}">
            <i class="fas fa-key"></i>&nbsp;
            Change Password
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i
                    class="fa-solid fa-right-from-bracket"></i>&nbsp;
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </div>
        </li>
        @endguest
        </li>
     </ul>
 </nav>
