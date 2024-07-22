<div class="topbar">            
                <!-- Navbar -->
                <nav class="navbar-custom">    
                    <ul class="list-unstyled topbar-nav float-end mb-0">  
                    @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                    @else

                        <li class="dropdown">    
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                              <span  style="border-radius: 10px; font-size:13px;font-weight:bold; box-shadow: 0px 2px 6px 4px rgba(22, 119, 170, 0.4);">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a class="dropdown-item" href="pages-profile.html"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Profile</a> -->
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" href="{{route('change-password')}}">
                                      
                                                     <i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i>
                                                     {{ __(' የይለፍ ቃል ይቀይሩ') }} 
                                    </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i>
                                        {{ __('ይውጡ') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        
                                        @csrf
                                    </form>
                            </div>
                        </li>
                        @endguest
                    </ul><!--end topbar-nav-->
        
                    <ul class="list-unstyled topbar-nav mb-0">                        
                        <li>
                            <button class="nav-link button-menu-mobile">
                                <i data-feather="menu" class="align-self-center topbar-icon"></i>
                            </button>
                        </li> 
                                                   
                    </ul>
                    
                </nav>
                <!-- end navbar-->
            </div>