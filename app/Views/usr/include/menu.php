            <div class="collapse navbar-collapse order-3 justify-content-end" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link">홈</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">게시판</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="/board/notice/list" class="dropdown-item">공지사항</a></li>
                            <li><a href="/board/free/list" class="dropdown-item">자유게시판</a></li>
                        </ul>
                    </li>
<?php   if (getUserSessionInfo("auth_group") == "guest") { ?>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">마이페이지</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="/member/login" class="dropdown-item">로그인</a></li>
                            <li><a href="/member/join" class="dropdown-item">회원가입</a></li>
                        </ul>
                    </li>
<?php   } else { ?>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">마이페이지</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="/member/myinfo" class="dropdown-item">내정보</a></li>
                            <li><a href="/member/logout" class="dropdown-item">로그아웃</a></li>
                        </ul>
                    </li>
<?php   } ?>
                </ul>
            </div>

        </div>
    </nav>
    <!-- /.navbar -->
