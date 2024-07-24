<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\FileModel;
use App\Models\Common\SpreadsheetModel;
use App\Models\Common\DateModel;

class BulkModel extends Model
{
    public function getBulkList($data)
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
        $builder = $db->table("bulk");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("b_idx", "desc");
        $builder->limit($rows, getOffset($page, $rows));
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

    public function procBulkInsert($data)
    {
        $file_model = new FileModel();
        $spreadsheet_model = new SpreadsheetModel();

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $bulk_file = $data["bulk_file"];

        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $file_info = $file_model->getFileInfo($bulk_file);
        $model_result = $spreadsheet_model->procExcelRead($file_info);
        $list = $model_result["list"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("bulk");
        $builder->set("title", $title);
        $builder->set("bulk_file", $bulk_file);
        $builder->set("del_yn", "N");
        $builder->set("ins_id", $user_id);
        $builder->set("ins_date", $today);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $result = $builder->insert();
        $insert_id = $db->insertID();

        foreach ($list as $no => $val) {
            $builder = $db->table("bulk_detail");
            $builder->set("b_idx", $insert_id);
            $builder->set("data_json", json_encode($val));
            $builder->set("del_yn", "N");
            $builder->set("ins_id", $user_id);
            $builder->set("ins_date", $today);
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $result = $builder->insert();
        }

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

    public function getBulkDetail($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        $b_idx = $data["b_idx"];

        $db = $this->db;
        $builder = $db->table("bulk_detail");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->limit($rows, getOffset($page, $rows));
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->json_arr = json_decode($val->data_json);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getBulkInfo($bd_idx)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("bulk_detail");
        $builder->where("del_yn", "N");
        $builder->where("bd_idx", $bd_idx);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }


    public function procBulkUpdate($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $bd_idx = $data["bd_idx"];
        $member_name = $data["member_name"];
        $email = $data["email"];
        $phone = $data["phone"];
        $gender = $data["gender"];
        $post_code = $data["post_code"];
        $addr1 = $data["addr1"];
        $addr2 = $data["addr2"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("bulk_detail");
        $builder->set("member_name", $member_name);
        $builder->set("email", $email);
        $builder->set("phone", $phone);
        $builder->set("gender", $gender);
        $builder->set("post_code", $post_code);
        $builder->set("addr1", $addr1);
        $builder->set("addr2", $addr2);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("bd_idx", $bd_idx);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    // 게시판 삭제
    public function procBulkDelete($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $bd_idx = $data["bd_idx"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("bulk_detail");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("bd_idx", $bd_idx);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}
