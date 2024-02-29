<?php

namespace App\Models\Common;

use CodeIgniter\Model;

/**
 * [Description AuthorityModel]
 * 권한관리 모델
 */
class AuthorityModel extends Model
{
    // uri에 따라 권한 체크 후 로그인이 필요한 경우 리다이렉션
    public function checkAuthority($segments)
    {
        $user_session = getUserSession();
        $auth_group = $user_session->auth_group;

        $segment0 = $segments[0] ?? null;
        $segment1 = $segments[1] ?? null;

        // 관리자 접근인데 권한이 관리자가 아니라면
        if ($segment0 == "csl" && $auth_group != "admin") {
            header("Location: /user/login");
            exit;
        }

        // 반드시 로그인이 필요한 페이지
        $uri = $segment0."/".$segment1;

        $login_arr = array();
        $login_arr[] = "mypage/mypage";
        if (in_array($uri, $login_arr) == true && $auth_group == "guest") {
            header("Location: /user/login");
            exit;
        }
    }

}
