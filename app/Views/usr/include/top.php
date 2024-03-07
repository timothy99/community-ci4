        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=getUserSessionInfo("member_nickname") ?></span>
                                <img class="img-profile rounded-circle" src="/resource/usr/image/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
<?php   if (getUserSessionInfo("auth_group") == "guest") { ?>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/member/login">
                                    로그인
                                </a>
                                <a class="dropdown-item" href="/member/join">
                                    회원가입
                                </a>
                            </div>
<?php   } else { ?>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/member/myinfo">
                                    내정보
                                </a>
                                <a class="dropdown-item" href="/member/logout">
                                    나가기
                                </a>
                            </div>
<?php   } ?>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
