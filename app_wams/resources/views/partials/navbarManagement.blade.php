{{-- @if (Auth::user()->hasRole('Management'))
@endif
 --}}



 <nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style="color: rgb(243, 242, 242)"></i></a></li>
      <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    <div class="search-element">
      <input class="form-control"  type="search" placeholder="Search" aria-label="Search" data-width="500" style="border-radius: 1em; border-color:rgba(208, 208, 208, 0.947)">
      <button class="btn" type="submit" style="margin-left: 20px; border-radius:1em; background-color:rgba(208, 208, 208, 0.947); color:white">Search</button>
    </div>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle" style="margin-right:0.6em">
      <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
        
        <i class="fa fa-bell" style="color: rgb(27, 27, 27); ">
            @if (!$datas)
              <span></span>   
              @else
              <span>{{$datas}}</span>               
              @endif
        </i>
        {{-- <i class="fa fa-bell" style="color: rgb(27, 27, 27); ">{{$loop->iteration}}</i> --}}
      </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
          <div class="float-right">
            <a href="#">Mark All As Read</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
          {{-- @foreach ($datas as $item)

          <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-icon bg-primary text-white">
              <i class="fas fa-code"></i>
            </div>
            <div class="dropdown-item-desc">
              Template update is available now!
              <div class="time text-primary">2 Min Ago</div>
            </div>
          </a>
      @endforeach --}}
          <a href="#" class="dropdown-item">
              @if ($datas)
              <div class="dropdown-item-icon bg-info text-white">
                <i class="far fa-user"></i>
              </div>
              <div class="dropdown-item-desc">
                  <a href="/approval">Approval <span class="text-danger">{{$datas}}</span></a>
                  {{-- <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                    <div class="time">10 Hours Ago</div> --}}
              </div>
              @endif
          </a>
          {{-- <a href="#" class="dropdown-item">
            <div class="dropdown-item-icon bg-success text-white">
              <i class="fas fa-check"></i>
            </div>
            <div class="dropdown-item-desc">
              <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
              <div class="time">12 Hours Ago</div>
            </div>
          </a>
          <a href="#" class="dropdown-item">
            <div class="dropdown-item-icon bg-danger text-white">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="dropdown-item-desc">
              Low disk space. Let's clean it!
              <div class="time">17 Hours Ago</div>
            </div>
          </a>
          <a href="#" class="dropdown-item">
            <div class="dropdown-item-icon bg-info text-white">
              <i class="fas fa-bell"></i>
            </div>
            <div class="dropdown-item-desc">
              Welcome to Stisla template!
              <div class="time">Yesterday</div>
            </div>
          </a> --}}
        </div>
        <div class="dropdown-footer text-center">
          <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>

    {{-- acount --}}
    @if (!Auth::user())
        <p>none</p>
    @endif
    <div class="d-sm-none d-lg-inline-block" style="color: black; margin-right:0.6em">{{ Auth::user()->name}}</div></a>

    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">Logged in 5 min ago</div>
        <a href="features-profile.html" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>
        <a href="features-activities.html" class="dropdown-item has-icon">
          <i class="fas fa-bolt"></i> Activities
        </a>
        <a href="features-settings.html" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> Settings
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item has-icon text-danger">
          <form action="/logout" method="POST">
            @csrf
            <button class="btn btn-danger">Logout</button>
          </form>
        </a>
      </div>
    </li>
  </ul>
</nav>
