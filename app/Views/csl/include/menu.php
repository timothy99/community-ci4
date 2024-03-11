<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/csl">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?=env("app.sitenameAdmin") ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="li-dashboard">
                <a class="nav-link" href="/csl/dashboard/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>대시보드</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">게시판</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item" id="li-board-notice-list">
                <a class="nav-link collapsed" id="a-board-notice-list-upper" href="/csl/board/notice/list" data-toggle="collapse" data-target="#div-board-notice-list" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>게시판</span>
                </a>
                <div id="div-board-notice-list" class="collapse" aria-labelledby="collapseTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">게시판</h6>
                        <a class="collapse-item" id="a-board-notice-list" href="/csl/board/notice/list">공지사항</a>
                        <a class="collapse-item" id="a-board-free-list" href="/csl/board/free/list">자유</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                단일메뉴
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item" id="li-member-list">
                <a class="nav-link" href="/csl/member/list" id="a-member-list">
                    <i class="fas fa-fw fa-table"></i>
                    <span>회원관리</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->