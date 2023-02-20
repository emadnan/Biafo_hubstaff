@php
$permission_roles = session()->get('permission_roles_array');
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3 mb-5">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!--Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li  >
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>
                @if(isset($permission_roles['Read_Library'])||Auth::user()->user_type=="super_admin")
                <li>

                    <a class="{{ request()->routeIs('library') ? 'nav-link active' : 'nav-link' }}"
                        href="{{ route('library') }}">
                        <i class="nav-icon fa-solid fa-book-atlas"></i>
                        <p>
                            Library
                        </p>
                    </a>
                </li>
                @endif
                @if(isset($permission_roles['Read_Contract']) || Auth::user()->user_type=="super_admin")
                @if(Auth::user()->can_access_contract=="1")
                <li>
                    <a class="{{ request()->routeIs('contracts') || request()->routeIs('/contracts/archived_contracts') ? 'nav-link active' : 'nav-link' }}"
                        href="{{ route('contracts') }}"><i class="nav-icon fa-solid fa-file-signature"></i>
                        <p>Contract Management
                        </p>
                    </a>
                </li>
                @endif
                @endif
                @if(isset($permission_roles['Read_Internal_Policy'])||Auth::user()->user_type=='super_admin')
                <li>
                    <a class="{{ request()->routeIs('internalpolicies') ? 'nav-link active' : 'nav-link' }}"
                        href="{{ route('internalpolicies') }}"><i class="nav-icon fa-solid fa-file"></i></i>
                        <p>Internal Policies
                        </p>
                    </a>
                </li>
                @endif
                <li  >
                    <a class="{{ request()->routeIs('notification') ? 'nav-link active' : 'nav-link' }}"
                        href="{{route('notification')}}"><i class="nav-icon fas fa-bell"></i>
                        <p>Notifications
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
