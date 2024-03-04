<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;
use Throwable;

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

        if (strlen($member_password) < 8 != strlen($member_password_confirm) < 8) {
            $result = false;
            $message = "입력된 비밀번호는 8자리 이상이어야 합니다.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    public function procMember($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");

        $member_id = $data["member_id"];
        $member_password = $data["member_password"];
        $member_name = $data["member_name"];
        $member_nickname = $data["member_nickname"];
        $phone = $data["phone"];
        $email = $data["email"];
        $post_code = $data["post_code"];
        $addr1 = $data["addr1"];
        $addr2 = $data["addr2"];

        $gender = "M";
        $join_type = "direct";
        $email_yn = "N";
        $post_yn = "N";
        $sms_yn = "N";
        $auth_group = "common";

        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        try {
            $db = db_connect();
            $db->transStart();
            $builder = $db->table("mng_member");
            $builder->set("member_id", $member_id);
            $builder->set("member_password", $member_password_enc);
            $builder->set("member_name", $member_name);
            $builder->set("member_nickname", $member_nickname);
            $builder->set("email", $email);
            $builder->set("phone", $phone);
            $builder->set("gender", $gender);
            $builder->set("post_code", $post_code);
            $builder->set("addr1", $addr1);
            $builder->set("addr2", $addr2);
            $builder->set("join_type", $join_type);
            $builder->set("email_yn", $email_yn);
            $builder->set("post_yn", $post_yn);
            $builder->set("sms_yn", $sms_yn);
            $builder->set("auth_group", $auth_group);
            $builder->set("last_login_date", $today);
            $builder->set("del_yn", "N");
            $builder->set("ins_id", $member_id);
            $builder->set("ins_date", $today);
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $result = $builder->insert();
            $insert_id = $db->insertID();
            $db->transComplete();
        } catch (Throwable $t) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            logMessage($t->getMessage());
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["insert_id"] = $insert_id;

        return $proc_result;
    }

}
