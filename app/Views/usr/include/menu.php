            <div class="collapse navbar-collapse order-3 justify-content-end" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link">홈</a>
                    </li>
<?php   if (getUserSessionInfo("auth_group") == "guest") { ?>
                    <li class="nav-item">
                        <a href="/member/login" class="nav-link">로그인</a>
                    </li>
<?php   } else { ?>
                    <li class="nav-item">
                        <a href="/member/logout" class="nav-link">로그아웃</a>
                    </li>
<?php   } ?>
                </ul>
            </div>

        </div>
    </nav>
    <!-- /.navbar -->
