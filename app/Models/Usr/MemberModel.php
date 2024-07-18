<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;
use App\Models\Common\DateModel;

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

        if (strlen($member_password) < 8) {
            $result = false;
            $message = "입력된 비밀번호는 8자리 이상이어야 합니다.";
        }

        if (strlen($member_id) < 6) {
            $result = false;
            $message = "아이디는 6자리 이상 입력해야 합니다.";
        }

        $restrict_id_arr = ["master", "guest", "adm"];
        foreach($restrict_id_arr as $no => $val) {
            $restrict_position = strrpos($member_id, $val) ?? 0;
            if ($restrict_position > -1) {
                $result = false;
                $message = "사용이 불가한 아이디입니다. 다른 아이디를 입력해주세요.";
            }
        }

        // 영어 소문자, 숫자, 언더바
        $pattern_result = preg_match("/[^a-z0-9_]/", $member_id);
        if ($pattern_result == true) {
            $result = false;
            $message = "아이디는 영어 소문자, 숫자만 입력이 가능합니다.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    public function getMemberIdDuplicate($data)
    {
        $result = true;
        $message = "중복된 아이디가 없습니다.";

        $member_id = $data["member_id"];

        $db = $this->db;
        $builder = $db->table("member");
        $builder->select("count(*) as cnt");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $info = $builder->get()->getFirstRow();

        $cnt = $info->cnt;
        if ($cnt > 0) {
            $result = false;
            $message = "아이디가 중복되었습니다. 다른 아이디를 선택해주세요.";
        }

        if (strlen($member_id) < 6) {
            $result = false;
            $message = "아이디는 6자리 이상 입력해야 합니다.";
        }

        $restrict_id_arr = ["master", "guest", "adm"];
        foreach($restrict_id_arr as $no => $val) {
            $restrict_position = strrpos($member_id, $val) ?? 0;
            if ($restrict_position > -1) {
                $result = false;
                $message = "사용이 불가한 아이디입니다. 다른 아이디를 입력해주세요.";
            }
        }

        // 영어 소문자, 숫자, 언더바
        $pattern_result = preg_match("/[^a-z0-9_]/", $member_id);
        if ($pattern_result == true) {
            $result = false;
            $message = "아이디는 영어 소문자, 숫자만 입력이 가능합니다.";
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

        $auth_group = "common";
        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("member_id", $member_id);
        $builder->set("member_password", $member_password_enc);
        $builder->set("member_name", $member_name);
        $builder->set("member_nickname", $member_nickname);
        $builder->set("email", $email);
        $builder->set("phone", $phone);
        $builder->set("post_code", $post_code);
        $builder->set("addr1", $addr1);
        $builder->set("addr2", $addr2);
        $builder->set("auth_group", $auth_group);
        $builder->set("last_login_date", $today);
        $builder->set("del_yn", "N");
        $builder->set("ins_id", $member_id);
        $builder->set("ins_date", $today);
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $result = $builder->insert();
        $insert_id = $db->insertID();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
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

        $db = $this->db;

        $builder = $db->table("member");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $builder->where("member_password", $member_password_enc);
        $list = $builder->get()->getResult();
        $cnt = count($list);

        if ($cnt == 1) {
            $member_info = $list[0];

            $builder = $db->table("member");
            $builder->set("last_login_date", $today);
            $builder->set("last_login_ip", $ip_address);
            $builder->where("member_id", $member_id);
            $result = $builder->update();

            if ($db->transStatus() === false) {
                $result = false;
                $message = "입력에 오류가 발생했습니다.";
                $db->transRollback();
            } else {
                $db->transCommit();
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

    // 회원 로그인 결과
    public function getMemberInfo()
    {
        $date_model = new DateModel();

        $result = true;
        $message = "정상처리";

        $member_id = getUserSessionInfo("member_id");
        $auth_group = getUserSessionInfo("auth_group");

        if ($auth_group == "guest") {
            redirect_alert("로그인 해야합니다", "/");
        }

        $db = $this->db;
        $builder = $db->table("member");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $info = $builder->get()->getRow();

        $info->last_login_date_txt = $date_model->convertTextToDate($info->last_login_date, 1, 1);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    // 회원정보 입력
    public function procMemberUpdate($data)
    {
        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");
        $member_id = getUserSessionInfo("member_id");

        $member_name = $data["member_name"];
        $member_nickname = $data["member_nickname"];
        $phone = $data["phone"];
        $email = $data["email"];
        $post_code = $data["post_code"];
        $addr1 = $data["addr1"];
        $addr2 = $data["addr2"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("member_name", $member_name);
        $builder->set("member_nickname", $member_nickname);
        $builder->set("email", $email);
        $builder->set("phone", $phone);
        $builder->set("post_code", $post_code);
        $builder->set("addr1", $addr1);
        $builder->set("addr2", $addr2);
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("member_id", $member_id);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    // 회원정보 입력
    public function procMemberDelete()
    {
        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");
        $member_id = getUserSessionInfo("member_id");

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("member_id", $member_id);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

}
