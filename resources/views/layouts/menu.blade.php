<div class="container">
  <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="{{ route('home') }}">Home </a>
        <a class="nav-item nav-link" href="{{ route('category') }}">Categories</a>
        <a class="nav-item nav-link" href="{{ route('library') }}">Library</a>
        <a class="nav-item nav-link" href="{{ route('sector') }}">Sectors</a> 
        <a class="nav-item nav-link" href="{{ route('policy') }}">Policies</a> 
        <a class="nav-item nav-link" href="{{ route('contracts') }}">Contract Management</a> 
        <a class="nav-item nav-link" href="{{ route('department') }}">Departments</a>
        <a class="nav-item nav-link" href="{{ route('subject') }}">Subjects</a>
        @if(Auth::user()->user_type=='super_admin')
        <a class="nav-item nav-link" href="{{ route('subscription') }}">Subscriptions</a>
         @endif
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Users
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="{{ route('users') }}">Users</a></li>
              @if(Auth::user()->user_type=='super_admin')
              <li><a class="dropdown-item" href="{{ route('user_roles') }}">Roles</a></li>
              <li><a class="dropdown-item" href="/permissions">Permissions</a></li>
              <li><a class="dropdown-item" href="/permissions_roles">Permissions Roles</a></li>
              @endif
              @if(Auth::user()->user_type=='company_admin')
              <li><a class="dropdown-item" href="{{ route('teams') }}">Teams</a></li>
              @endif
            </ul>
          </li>
        </ul>
      </div>

      </div>
    </div>
  </nav>
</div>
