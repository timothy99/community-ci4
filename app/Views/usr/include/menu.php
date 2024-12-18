        <div class="collapse navbar-collapse order-3 justify-content-end" id="navbarCollapse">
            <ul class="navbar-nav">
<?php   foreach ($menu_list as $no => $val) { ?>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="<?=$val->http_link ?>" data-toggle="<?php if (count($val->list) > 0) echo "dropdown"; ?>" aria-haspopup="true" aria-expanded="false" class="nav-link <?php if (count($val->list) > 0) echo "dropdown-toggle"; ?>"><?=$val->menu_name ?></a>
<?php       if (count($val->list) > 0) { ?>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
<?php           foreach ($val->list as $no2 => $val2) { ?>
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="<?=$val2->http_link ?>" role="button" data-toggle="<?php if (count($val2->list) > 0) echo "dropdown"; ?>" aria-haspopup="true" aria-expanded="false" class="dropdown-item <?php if (count($val2->list) > 0) echo "dropdown-toggle"; ?>"><?=$val2->menu_name ?></a>
<?php               if (count($val2->list) > 0) { ?>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
<?php                   foreach ($val2->list as $no3 => $val3) { ?>
                                <li><a href="<?=$val3->http_link ?>" class="dropdown-item"><?=$val3->menu_name ?></a></li>
<?php                   } ?>
                            </ul>
<?php               } ?>
                        </li>
<?php           } ?>
                    </ul>
<?php       } ?>
                </li>
<?php   } ?>

<?php   if (getUserSessionInfo("auth_group") == "guest") { ?>
                <li class="nav-item ml-5">
                    <a href="/member/login" class="nav-link">로그인</a>
                </li>
<?php   } else { ?>
                <li class="nav-item pl-5">
                    <a href="/member/view" class="nav-link"><?=getUserSessionInfo("member_nickname") ?></a>
                </li>
                <li class="nav-item">
                    <a href="/member/logout" class="nav-link">로그아웃</a>
                </li>
<?php   } ?>
            </ul>
        </div>
    </div>
</nav>
