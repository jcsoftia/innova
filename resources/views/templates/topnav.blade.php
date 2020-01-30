<div class="topbar-main ">
                <div class="container-fluid">

                    <!-- Logo-->
                    <div class="">
                        <a href="/" class="logo">

                            <span class="d-none d-sm-inline logo-light">
                                   <img width="250px" src="./icon.png" alt="logo">
                            </span>
                            <span class="d-sm-none d-inline logo-light">
                                    <i class="mdi mdi-camera-control"></i><span class="">FH</span>
                            </span>
                        </a>
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">


                            <li class="dropdown notification-list list-inline-item">
                                <div class="dropdown notification-list nav-pro-img">

                                    <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="./assets/img/icon.png" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1 profile-dropdown ">
                                        <!-- item-->

                                        <a class="dropdown-item text-info" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> {{ __('Logout') }}</a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item dropdown notification-list list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
