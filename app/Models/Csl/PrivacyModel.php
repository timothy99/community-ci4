<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;
use Exception;
use App\Models\Common\DateModel;

class PrivacyModel extends Model
{
    public function getPrivacyList($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        $db = $this->db;
        $builder = $db->table("privacy");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->where($search_condition, $search_text);
        }

        if ($rows > 0) { // 0보다 클 경우 화면에 보여지는것이니 limit를 건다.
            $builder->limit($rows, getOffset($page, $rows));
        }
        $builder->orderBy("p_idx", "desc");
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getMemberInfo($member_id)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("member");
        $builder->where("del_yn", "N");
        $builder->where("member_id", $member_id);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    // 회원정보 입력
    public function procMemberUpdate($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");
        $upd_id = getUserSessionInfo("member_id");

        $member_id = $data["member_id"];
        $member_name = $data["member_name"];
        $member_nickname = $data["member_nickname"];
        $phone = $data["phone"];
        $email = $data["email"];
        $post_code = $data["post_code"];
        $addr1 = $data["addr1"];
        $addr2 = $data["addr2"];
        $auth_group = $data["auth_group"];

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
        $builder->set("auth_group", $auth_group);
        $builder->set("last_login_date", $today);
        $builder->set("upd_id", $upd_id);
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
    public function procMemberDelete($data)
    {
        $security_model = new SecurityModel();

        $result = true;
        $message = "정상처리";

        $today = date("YmdHis");
        $upd_id = getUserSessionInfo("member_id");

        $member_id = $data["member_id"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("member");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $upd_id);
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
