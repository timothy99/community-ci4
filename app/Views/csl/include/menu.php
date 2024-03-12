    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link text-center">
            <span class="brand-text font-weight-light"><?=env("app.sitename") ?></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="text-center"><?=getUserSessionInfo("member_nickname") ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">메뉴</li>
                    <li class="nav-item" id="li-home-home">
                        <a href="/home/home" class="nav-link" id="upper-home-home">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>대시보드</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-board-notice-list">
                        <a href="#" class="nav-link" id="upper-board-notice-list">
                            <i class="nav-icon fas fa-table"></i>
                            <p>게시판<i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/board/notice/list" class="nav-link" id="a-board-notice-list">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>공지사항</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
