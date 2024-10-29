  <!-- ========== Topbar Start ========== -->
  <div class="navbar-custom">
      <div class="topbar container-fluid">
          <div class="d-flex align-items-center gap-1">

              <!-- Topbar Brand Logo -->
              <div class="logo-topbar">
                  <!-- Logo light -->
                  <a href="index.html" class="logo-light">
                      <span class="logo-lg">
                          <img src="assets/images/logo.png" alt="logo">
                      </span>
                      <span class="logo-sm">
                          <img src="assets/images/logo-sm.png" alt="small logo">
                      </span>
                  </a>

                  <!-- Logo Dark -->
                  <a href="index.html" class="logo-dark">
                      <span class="logo-lg">
                          <img src="assets/images/logo-dark.png" alt="dark logo">
                      </span>
                      <span class="logo-sm">
                          <img src="assets/images/logo-sm.png" alt="small logo">
                      </span>
                  </a>
              </div>

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

              <!-- Topbar Search Form -->
              {{-- <div class="app-search d-none d-lg-block">
                  <form>
                      <div class="input-group">
                          <input type="search" class="form-control" placeholder="Search...">
                          <span class="ri-search-line search-icon text-muted"></span>
                      </div>
                  </form>
              </div> --}}
          </div>

          <ul class="topbar-menu d-flex align-items-center gap-3">
              <li class="dropdown d-lg-none">
                  <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                      aria-haspopup="false" aria-expanded="false">
                      <i class="ri-search-line fs-22"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                      <form class="p-3">
                          <input type="search" class="form-control" placeholder="Search ..."
                              aria-label="Recipient's username">
                      </form>
                  </div>
              </li>

              <li class="dropdown">
                  <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                      aria-haspopup="false" aria-expanded="false">
                      <img src="assets/images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1" height="12">
                      <span class="align-middle d-none d-lg-inline-block">English</span> <i
                          class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                      <!-- item-->
                      <a href="javascript:void(0);" class="dropdown-item">
                          <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12">
                          <span class="align-middle">German</span>
                      </a>

                      <!-- item-->
                      <a href="javascript:void(0);" class="dropdown-item">
                          <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span
                              class="align-middle">Italian</span>
                      </a>

                      <!-- item-->
                      <a href="javascript:void(0);" class="dropdown-item">
                          <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span
                              class="align-middle">Spanish</span>
                      </a>

                      <!-- item-->
                      <a href="javascript:void(0);" class="dropdown-item">
                          <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12">
                          <span class="align-middle">Russian</span>
                      </a>

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

              {{-- 
              <li class="d-none d-sm-inline-block">
                  <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                      <i class="ri-settings-3-line fs-22"></i>
                  </a>
              </li> --}}

              <li class="d-none d-sm-inline-block">
                  <div class="nav-link" id="light-dark-mode">
                      <i class="ri-moon-line fs-22"></i>
                  </div>
              </li>

              <li class="dropdown">
                  <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                      role="button" aria-haspopup="false" aria-expanded="false">
                      <span class="account-user-avatar">
                          <img src="assets/images/users/avatar-1.jpg" alt="user-image" width="32"
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
