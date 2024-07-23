<?php

namespace App\Models\Lgn;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;

class PasswordModel extends Model
{
    // 회원 로그인 결과
    public function getMemberInfo($data)
    {
        $result = true;
        $message = "정상처리";

        $email = $data["email"];

        $db = $this->db;
        $builder = $db->table("member");
        $builder->where("del_yn", "N");
        $builder->where("email", $email);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    // 회원 로그인 결과
    public function getPasswordInfo($data)
    {
        $result = true;
        $message = "정상처리";

        $email = $data["email"];
        $member_id = $data["member_id"];

        $db = $this->db;
        $builder = $db->table("member");
        $builder->where("del_yn", "N");
        $builder->where("email", $email);
        $builder->where("member_id", $member_id);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    // 리셋정보 등록
    public function procResetInsert($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $email = $data["email"];
        $member_id = $data["member_id"];

        $reset_key = $security_model->getRandomString(4, 32); // 보안을 위한 랜덤문자 생성
        $expire_date = date("YmdHis", strtotime("+15 minutes"));

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member_reset");
        $builder->where("email", $email);
        $builder->where("member_id", $member_id);
        $result = $builder->delete();

        $builder = $db->table("member_reset");
        $builder->set("member_id", $member_id);
        $builder->set("email", $email);
        $builder->set("reset_key", $reset_key);
        $builder->set("expire_date", $expire_date);
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
        $proc_result["reset_key"] = $reset_key;

        return $proc_result;
    }

    public function getResetInfo($data)
    {
        $result = true;
        $message = "정상처리";

        $reset_key = $data["reset_key"];

        $db = $this->db;
        $builder = $db->table("member_reset");
        $builder->where("reset_key", $reset_key);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procPasswordReset($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $model_result = $this->getResetInfo($data);
        $info = $model_result["info"];
        $member_id = $info->member_id;
        $email = $info->email;

        $member_password = $data["member_password"];
        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("member_password", $member_password_enc);
        $builder->where("email", $email);
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

    // 아이디 기준으로 암호가 맞는지 확인
    public function getMemberPasswordInfo($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $member_id = $data["member_id"];
        $member_password = $data["member_password"];
        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        $db = $this->db;
        $builder = $db->table("member");
        $builder->where("member_id", $member_id);
        $builder->where("member_password", $member_password_enc);
        $list = $builder->get()->getResult();
        $cnt = count($list);

        if ($cnt == 1) {
            $result = true;
            $message = "잘 찾음";
        } else {
            $result = false;
            $message = "암호가 맞지 않습니다.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    public function procPasswordUpdate($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $member_id = $data["member_id"];
        $member_password = $data["member_password"];
        $member_password_enc = $security_model->getPasswordEncrypt($member_password);

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("member_password", $member_password_enc);
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
