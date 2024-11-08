<div class="left-sidenav" style="background-color: #215467;">
            <!-- LOGO -->
            <div class="brand">
                
                    <span>
                   
                        @php $user=auth()->user();@endphp
                        @if($user->orgUnit_id == 1)
                            <img src="{{ asset('assets/images/FSC.png') }}" alt="Logo 1" class="logo-md" width="120" height="120">
                        @elseif($user->orgUnit_id == 2)
                            <img src="{{ asset('assets/images/ffc.png') }}" alt="Logo 2" style="border-radius: 50%; object-fit: fill" class="logo-md" width="120" height="120">
                        @elseif($user->orgUnit_id == 3)
                            <img src="{{ asset('assets/images/fic.png') }}" alt="Logo 3" style="border-radius: 50%; object-fit: contain; " class="logo-md" width="120" height="120">
                        @else
                            <img src="{{ asset('assets/images/FSC.png') }}" alt="Default Logo" class="logo-md" width="120" height="120">
                        @endif

                    </span>
                      
                    <!-- <span>
                        <img src="{{ asset('assets/images/aiiLogo.png') }}" height="50" alt="logo-large" class="logo-lg logo-light">
                        
                    </span> -->
                </a>
                </div>

            <!--end logo-->
            <div class="menu-content h-100" data-simplebar>
                <ul class="metismenu left-sidenav-menu">
                <li class="menu-label mt-0"><h5 style="color: #215467;">|</h5></li>
                    <!-- <li>
                        <a href="javascript: void(0);"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="index.html"><i class="ti-control-record"></i>Analytics</a></li>
                            <li class="nav-item"><a class="nav-link" href="sales-index.html"><i class="ti-control-record"></i>Sales</a></li> 
                        </ul>
                    </li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="/home"><i data-feather="home" class="align-self-center menu-icon"></i>Dashboard</a></li> -->
    
                  <!--  <li class="nav-item"><a class="nav-link" href="#"><i data-feather="home" class="align-self-center menu-icon"></i>ማሳያ</a></li>-->

                   @can('use_transcription_page') 
                    <li  class="nav-item active"><a class="nav-link" href="{{ route('voices.voice.index') }}" ><i  class="align-self-center fas fa-file-audio"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">ድምጽን ወደ ጽሁፍ መቀየሪያ </h6></a></li>
                    </li>
                    @endcan
                    @can('transcription_list') 
                    <li class="nav-item  waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('voices.voice.show') }}"><i class="align-self-center fas fa-list-alt"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የቅያሪዎች መዝገብ</h6></a>
                    </li>
                    @endcan
                    @can('access_judge_page')
                    <li class="nav-item waves-effect waves-light btn-round "><a class="nav-link" href="{{ route('voices.voice.request_edits') }}"><i class="aalign-self-center fas fa-list-ol" style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የማስተካከያ ጥያቄዎች </h6></a></li>
                    </li> 
                    @endcan
                    @can('approve_transcription')
                    <li class="nav-item waves-effect waves-light btn-round "><a class="nav-link" href="{{ route('voices.voice.supervisor_editRequest') }}"><i class="aalign-self-center fas fa-list-ol"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የማስተካከያ ጥያቄዎች</h6> </a></li>
                    </li>
                    @endcan
                    @can('user-list')
                    <li class="nav-item waves-effect waves-light btn-round" ><a class="nav-link" href="{{ route('users.user.index') }}"><i data-feather="user" class="align-self-left menu-icon"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">ተጠቃሚዎች</h6></a></li>
                    </li>
                    @endcan
                    @can('role-list') 
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('roles.index') }}"><i  class="align-self-center fas fa-clipboard-list"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">ሚናዎች</h6></a></li>
                    </li> 
                    @endcan
                    @can('orgUnit-list')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('org_units.org_unit.index') }}"><i  class="align-self-center fas fa fa-gavel"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">ፍርድ ቤቶች</h6></a></li>
                    </li> 
                    @endcan 
                    @can('plaintiff_type_index')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('plaintiff_types.plaintiff_type.index') }}"><i  class="align-self-center fas fa-file-upload"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የከሳሽ አይነት መመዝገብያ</h6></a></li>
                    </li>
                    @endcan
                    @can('case_status_index')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('case_statuses.case_status.index') }}"><i  class="align-self-center fas fa-file-upload"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የጉዳይ ሁኔታ መመዝገብያ</h6></a></li>
                    </li>
                    @endcan
                    @can('case_type_index')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('case_types.case_type.index') }}"><i  class="align-self-center fas fa-file-upload"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የጉዳይ አይነት መመዝገብያ</h6></a></li>
                    </li>
                    @endcan
                    @can('accused_type_index')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('accused_types.accused_type.index') }}"><i  class="align-self-center fas fa-file-upload"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የተከሳሽ አይነት መመዝገብያ</h6></a></li>
                    </li>
                    @endcan
                    @can('audio_type_index')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('audio_types.audio_type.index') }}"><i  class="align-self-center fas fa-file-upload "  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">የድምጽ ቅጂ አይነት መመዝገብያ</h6></a></li>
                    </li>
                    @endcan
                    @can('role-create')
                    <li class="nav-item, waves-effect waves-light btn-round"><a class="nav-link" href="{{ route('settings.setting.index') }}"><i  class="align-self-center fas fa-calendar-alt"  style="color: white;"></i><h6 style="color: white; font-weight: bold; font-family:sans-serif;">ቀኖች ማስተካከያ</h6></a></li>
                    </li> 
                    @endcan

                    <!--
                   <li class="nav-item"><a class="nav-link" href="{{ route('rules.rule.index') }}"><i  class="align-self-center fas fa-book"></i>Rules</a></li>
                    </li>-->
                    <!--<li class="nav-item"><a class="nav-link" href="{{ route('settings.setting.index') }}"><i  class="align-self-center fas fa-gir"></i>Settings</a></li>-->
                    </li> 
                </ul>
                <script>
                const listItems = document.querySelectorAll('.nav-item');
                listItems.forEach(item => {
                    item.addEventListener('click', () => {
                        listItems.forEach(item => item.classList.remove('active'));
                        item.classList.add('active');
                    });
                });
               </script>
            </div>
        </div>