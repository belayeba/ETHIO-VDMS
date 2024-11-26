  <!-- ========== Topbar Start ========== -->
  <div class="navbar-custom">
      <div class="topbar container-fluid">
          <div class="d-flex align-items-center gap-1">
            
              <!-- Sidebar Menu Toggle Button -->
              <button class="button-toggle-menu">
                  <i class="ri-menu-line"></i>
              </button>

              <!-- Horizontal Menu Toggle Button -->
              <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                  <div class="lines">
                      <span></span>
                      <span></span>
                      <span></span>
                  </div>
              </button>

              
          </div>

          <ul class="topbar-menu d-flex align-items-center gap-3">
             

              <li class="dropdown">
                  <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                      aria-haspopup="false" aria-expanded="false">
                      <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image" class="me-0 me-sm-1" height="12">
                      <span class="align-middle d-none d-lg-inline-block">English</span> <i
                          class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                      <!-- item-->
                      <a href="javascript:void(0);" class="dropdown-item">
                          <img src="{{ asset('assets/images/flags/Ethiopia.png') }}" alt="user-image" class="me-1" height="12">
                          <span class="align-middle">Amharic</span>
                      </a>

                      <!-- item-->
                      {{-- <a href="javascript:void(0);" class="dropdown-item">
                          <img src="{{ asset('assets/images/flags/italy.jpg') }}" alt="user-image" class="me-1" height="12"> <span
                              class="align-middle">Italian</span>
                      </a> --}}

                  </div>
              </li>


              <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                      aria-haspopup="false" aria-expanded="false">
                      <i class="ri-notification-3-line fs-22"></i>
                      <span class="noti-icon-badge badge text-bg-pink" id="display_count"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                      <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                          <div class="row align-items-center">
                              <div class="col">
                                  <h6 class="m-0 fs-16 fw-semibold"> Notification</h6>
                              </div>
                              <div class="col-auto">
                                  <form action="{{ route('delete_all_notification') }}" method="POST">
                                      @csrf
                                      <button type="submit" class="text-dark text-decoration-underline">
                                          <small>Clear All</small>
                                      </button>
                                  </form>
                              </div>
                          </div>
                      </div>

                      <div id="display_notification" style="max-height: 300px; overflow-y: auto;">
                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-primary-subtle">
                                  <i class="mdi mdi-comment-account-outline text-primary"></i>
                              </div>
                              <p class="notify-details">
                                  <small class="noti-time"></small>
                              </p>
                          </a>
                      </div>

                      <!-- All-->
                      <a href="{{ route('read_all_notification') }}"
                          class="dropdown-item text-center text-primary text-decoration-underline fw-bold notify-item border-top border-light py-2">
                          View All
                      </a>

                  </div>
              </li>

              <li class="d-none d-sm-inline-block">
                  <div class="nav-link" id="light-dark-mode">
                      <i class="ri-moon-line fs-22"></i>
                  </div>
              </li>

              <li class="dropdown">
                  <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                      role="button" aria-haspopup="false" aria-expanded="false">
                      <span class="account-user-avatar">
                          <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" width="32"
                              class="rounded-circle">
                      </span>
                      <span class="d-lg-block d-none">
                          @auth
                              <h5 class="my-0 fw-normal">{{ Auth::user()->first_name }}<i
                                      class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                          @else
                              <h5 class="my-0 fw-normal">Guest<i
                                      class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                          @endauth
                      </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                      <!-- item-->
                      <div class=" dropdown-header noti-title">
                          <h6 class="text-overflow m-0">Welcome !</h6>
                      </div>

                      <!-- item-->
                      <a href="{{ route('user_profile') }}" class="dropdown-item">
                          <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                          <span>My Account</span>
                      </a>

                      <!-- item-->
                      <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                          <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                          <span>Logout</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                          @csrf
                      </form>
                  </div>
              </li>
          </ul>
      </div>
  </div>
  <script>
      $.ajax({
          url: '/get_new_message_count',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
              console.log(data);
              // Handle the notifications data as needed
              $('#display_count').text(data.new_notification);
              // Clear existing notifications
              const notificationsContainer = $('#display_notification');
              notificationsContainer.empty();

              // Loop through each notification and add it to the div
              data.data.forEach(function(notification) {
                  // Create the notification HTML structure
                  const notificationItem = `
                <a href="${notification.url}" class="dropdown-item notify-item">
                    <div class="notify-icon bg-primary-subtle">
                        <i class="mdi mdi-comment-account-outline text-primary"></i>
                    </div>
                    <p class="notify-details">${notification.message}
                        <small class="noti-time">${notification.subject}</small>
                    </p>
                </a>
            `;

                  // Append the notification item to the container
                  notificationsContainer.append(notificationItem);
              });
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error('Error fetching notifications:', textStatus, errorThrown);
          }
      });
  </script>
  <!-- ========== Topbar End ========== -->
