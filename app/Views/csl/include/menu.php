    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/csl" class="brand-link text-center">
            <span class="brand-text font-weight-light"><?=env("app.sitename") ?></span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="/csl/member/logout" class="d-block"><?=getUserSessionInfo("member_nickname") ?></a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar nav-flat nav-child-indent flex-column">
                    <li class="nav-header">메뉴</li>
                    <li class="nav-item" id="li-member-list">
                        <a href="/csl/member/list" class="nav-link" id="a-member-list">
                            <p>회원</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-menu-list">
                        <a href="/csl/menu/list" class="nav-link" id="a-menu-list">
                            <p>사용자 메뉴</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-bulk-list">
                        <a href="/csl/bulk/list" class="nav-link" id="a-bulk-list">
                            <p>벌크</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-slide-list">
                        <a href="/csl/slide/list" class="nav-link" id="a-slide-list">
                            <p>슬라이드</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-shortlink-list">
                        <a href="/csl/shortlink/list" class="nav-link" id="a-shortlink-list"><p>단축url</p></a>
                    </li>
                    <li class="nav-item" id="li-popup-list">
                        <a href="/csl/popup/list" class="nav-link" id="a-popup-list">
                            <p>레이어 팝업</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-ask-list">
                        <a href="/csl/ask/list" class="nav-link" id="a-ask-list">
                            <p>간편문의</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-contents-list">
                        <a href="/csl/contents/list" class="nav-link" id="a-contents-list">
                            <p>콘텐츠</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-youtube-list">
                        <a href="/csl/youtube/list" class="nav-link" id="upper-youtube-list">
                            <p>
                                유튜브
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/csl/youtube/list" class="nav-link" id="a-youtube-list">
                                    <p>설정 목록</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/csl/youtube/search" class="nav-link" id="a-youtube-search">
                                    <p>채널 검색</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" id="li-board-config-list">
                        <a href="/csl/board/config/list" class="nav-link" id="upper-board-config-list">
                            <p>
                                게시판 설정
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/csl/board/config/list" class="nav-link" id="a-board-config-list">
                                    <p>게시판 설정</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/csl/board/manage/list" class="nav-link" id="a-board-manage-list">
                                    <p>게시물 관리</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" id="li-privacy-list">
                        <a href="/csl/privacy/list" class="nav-link" id="a-privacy-list">
                            <p>개인정보</p>
                        </a>
                    </li>
                    <li class="nav-item" id="li-member-logout">
                        <a href="/member/logout" class="nav-link" id="a-member-logout">
                            <p>로그아웃</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>