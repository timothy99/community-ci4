<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;
use Throwable;

class MemberModel extends Model
{
    public function getMemberList($data)
    {
        $result = true;
        $message = "중복된 아이디가 없습니다.";
        $member_id = $data["member_id"];

        $db = db_connect();
        $builder = $db->table("mng_member");
        $builder->select("count(*) as cnt");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $info = $builder->get()->getFirstRow();

        $cnt = $info->cnt;
        if ($cnt > 0) {
            $result = false;
            $message = "아이디가 중복되었습니다. 다른 아이디를 선택해주세요.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    // 회원정보 입력
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

    // 회원 로그인 결과
    public function getMemberLoginInfo($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");

        $member_id = $data["member_id"];
        $member_password = $data["member_password"];
        $ip_address = $data["ip_address"];

        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        $db = db_connect();

        $builder = $db->table("mng_member");
        $builder->select("*");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $builder->where("member_password", $member_password_enc);
        $list = $builder->get()->getResult();
        $cnt = count($list);

        if ($cnt == 1) {
            $member_info = $list[0];
            try {
                $builder = $db->table("mng_member");
                $builder->set("last_login_date", $today);
                $builder->set("last_login_ip", $ip_address);
                $builder->where("member_id", $member_id);
                $result = $builder->update();
                $db->transComplete();
            } catch (Throwable $t) {
                $result = false;
                $message = "입력에 오류가 발생했습니다.";
                logMessage($t->getMessage());
            }
        } else {
            $result = false;
            $message = "회원정보가 다릅니다. 다시 확인해주세요.";
            $member_info = (object)array();
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["member_info"] = $member_info;

        return $proc_result;
    }

}
