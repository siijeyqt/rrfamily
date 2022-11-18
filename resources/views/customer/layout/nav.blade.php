<div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fa fa-search"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="nav-link">
                    <a href="{{ route('home') }}" class="btn btn-warning">Home</a>
                </li>
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    @if(Auth::guard('customer')->user()->photo == '')
                    <img alt="image" src="{{asset('uploads/default.png')}}" 
                    class="rounded-circle mr-1"></a>
                    @else
                    <img alt="image" src="{{asset('uploads/' .Auth::guard('customer')->user()->photo)}}" 
                    class="rounded-circle mr-1"></a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('customer_profile')}}" class="dropdown-item has-icon">
                            <i class="fa fa-user"></i> Edit Profile
                        </a>
                        <a href="{{route('customer_logout')}}" class="dropdown-item has-icon text-danger">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>