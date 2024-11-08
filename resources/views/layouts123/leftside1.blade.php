'<div class="left-sidenav">
            <!-- LOGO -->
            <div class="brand">
                <a href="index.html" class="logo">
                    <span>
                        <img src="{{ asset('assets/images/aiiLogo.png') }}"  alt="logo-small" class="logo-sm">
                    </span>
                    <!-- <span>
                        <img src="{{ asset('assets/images/aiiLogo.png') }}" height="50" alt="logo-large" class="logo-lg logo-light">
                        
                    </span> -->
                </a>
            </div>
            <!--end logo-->
            <div class="menu-content h-100" data-simplebar>
                <ul class="metismenu left-sidenav-menu">
                    <li class="menu-label mt-0">Main</li>
                    <!-- <li>
                        <a href="javascript: void(0);"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="index.html"><i class="ti-control-record"></i>Analytics</a></li>
                            <li class="nav-item"><a class="nav-link" href="sales-index.html"><i class="ti-control-record"></i>Sales</a></li> 
                        </ul>
                    </li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/home"><i data-feather="home" class="align-self-center menu-icon"></i>Dashboard</a></li> -->
    
                  <!--  <li class="nav-item"><a class="nav-link" href="#"><i data-feather="home" class="align-self-center menu-icon"></i>ማሳያ</a></li>-->

                      
                    <li class="nav-item"><a class="nav-link" href="{{ route('voices.voice.index') }}"><i  class="align-self-center fas fa-file-audio"></i>ድምዕን ወደ ጽሁፍ መቀየሪያ </a></li>
                    </li>
                    
                    
                    
                    <li class="nav-item"><a class="nav-link" href="{{ route('voices.voice.show') }}"><i class="align-self-center fas fa-list-alt"></i> የቅያረዎች መዝገብ</a></li>
                    </li>
                   
                    
                    <li class="nav-item"><a class="nav-link" href="{{ route('voices.voice.request_edits') }}"><i class="aalign-self-center fas fa-list-ol"></i> ለዳኛ የማስተካከያ ጥያቄዎች </a></li>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="{{ route('voices.voice.supervisor_editRequest') }}"><i class="aalign-self-center fas fa-list-ol"></i> ለተቆጣጣሪ የማስተካከያ ጥያቄዎች </a></li>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('users.user.index') }}"><i data-feather="user" class="align-self-center menu-icon"></i>ተጠቃሚዎች</a></li>
                    </li>
                   
                    
                   
                    <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"><i  class="align-self-center fas fa-clipboard-list"></i>ሚናዎች</a></li>
                    </li> 
                   

                   <!-- @can('orgUnit-list')-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('org_units.org_unit.index') }}"><i  class="align-self-center fas fa-id-card-alt"></i>ፍርድ ቤቶች</a></li>
                    </li> 
                   <!-- @endcan-->
                
                  <!--  @can('plaintiff_type_index',  ) -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('plaintiff_types.plaintiff_type.index') }}"><i  class="align-self-center fas fa-file-upload"></i>የከሳሽ አይነት መመዝገቢያ</a></li>
                    </li>
                  <!--  @endcan-->

                   <!-- @can('case_status_index')-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('case_statuses.case_status.index') }}"><i  class="align-self-center fas fa-file-upload"></i>የጉዳይ ሁኔታ መመዝገቢያ</a></li>
                    </li>
                  <!--  @endcan-->
                    
                  <!--  @can('case_status_index')-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('case_types.case_type.index') }}"><i  class="align-self-center fas fa-file-upload"></i>የጉዳይ አይነት መመዝገቢያ</a></li>
                    </li>
                  <!--  @endcan-->
                    
                  <!--  @can('accused_type_index')-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('accused_types.accused_type.index') }}"><i  class="align-self-center fas fa-file-upload"></i>የተከሳሽ አይነት መመዝገቢያ</a></li>
                    </li>
                  <!--  @endcan-->

                   <!-- @can('audio_type_index')-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('audio_types.audio_type.index') }}"><i  class="align-self-center fas fa-file-upload "></i>የድምጽ አይነት መመዝገቢያ</a></li>
                    </li>
                   <!-- @endcan-->

                    <!--
                   <li class="nav-item"><a class="nav-link" href="{{ route('rules.rule.index') }}"><i  class="align-self-center fas fa-book"></i>Rules</a></li>
                    </li>-->
                    <li class="nav-item"><a class="nav-link" href="{{ route('settings.setting.index') }}"><i  class="align-self-center fas fa-gir"></i>Settings</a></li>
                    </li> 
                </ul>
    
            </div>
        </div>