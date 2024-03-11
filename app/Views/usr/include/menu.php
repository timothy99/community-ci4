<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home/home">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?=env("app.sitename") ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="li-home-home-upper">
                <a class="nav-link" href="/home/home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>대시보드</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">다중메뉴</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item" id="li-menu-menu1-upper">
                <a class="nav-link collapsed" href="/menu/menu1" data-toggle="collapse" data-target="#div-menu-menu1" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>다중메뉴</span>
                </a>
                <div id="div-menu-menu1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">다중메뉴 설명</h6>
                        <a class="collapse-item" id="a-menu-menu1" href="/menu/menu1">다중메뉴1</a>
                        <a class="collapse-item" id="a-menu-menu2" href="/menu/menu2">다중메뉴2</a>
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
            <li class="nav-item" id="li-board-notice-upper">
                <a class="nav-link" href="/board/notice/list" id="a-board-notice">
                    <i class="fas fa-fw fa-table"></i>
                    <span>공지사항</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
\
        </ul>
        <!-- End of Sidebar -->