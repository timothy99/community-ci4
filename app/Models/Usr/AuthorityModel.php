<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class MemberModel extends Model
{
    public function checkSigninInfo($data)
    {
        $result = true;
        $message = "정상처리";

        $member_id = $data["member_id"];
        $member_password = $data["member_password"];
        $member_password_confirm = $data["member_password_confirm"];
        $member_name = $data["member_name"];
        $member_nickname = $data["member_nickname"];
        $phone = $data["phone"];
        $email = $data["email"];
        $post_code = $data["post_code"];
        $addr1 = $data["addr1"];
        $addr2 = $data["member_id"];

        if ($member_id == null) {
            $result = false;
            $message = "아이디를 입력해주세요.";
        }

        if ($member_name == null) {
            $result = false;
            $message = "이름을 입력해주세요.";
        }

        if ($member_nickname == null) {
            $result = false;
            $message = "닉네임을 입력해주세요.";
        }

        if ($phone == null) {
            $result = false;
            $message = "전화번호를 입력해주세요.";
        }

        if ($email == null) {
            $result = false;
            $message = "이메일을 입력해주세요.";
        }

        if ($post_code == null) {
            $result = false;
            $message = "주소를 입력해주세요.";
        }

        if ($member_password != $member_password_confirm) {
            $result = false;
            $message = "입력된 비밀번호가 다릅니다.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

}
