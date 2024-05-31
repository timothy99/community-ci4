<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use Throwable;
use App\Models\Common\FileModel;
use App\Models\Common\SpreadsheetModel;

class BulkModel extends Model
{
    public function getBulkList($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $rows = $data["rows"];
        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        // 오프셋 계산
        $offset = ($page-1)*$rows;
        if ($offset < 0) {
            $offset = 0;
        }

        $db = db_connect();
        $builder = $db->table("bulk");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("b_idx", "desc");
        $builder->limit($rows, $offset);
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    // 게시판 입력
    public function procBulkInsert($data)
    {
        $file_model = new FileModel();
        $spreadsheet_model = new SpreadsheetModel();

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $bulk_file = $data["bulk_file"];

        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $file_info = $file_model->getFileInfo($bulk_file);
        $model_result = $spreadsheet_model->procExcelRead($file_info);
        $list = $model_result["list"];

        try {
            $db = db_connect();
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
                $builder->set("member_name", $val->A);
                $builder->set("email", $val->B);
                $builder->set("phone", $val->C);
                $builder->set("gender", $val->D);
                $builder->set("post_code", $val->E);
                $builder->set("addr1", $val->F);
                $builder->set("addr2", $val->G);
                $builder->set("del_yn", "N");
                $builder->set("ins_id", $user_id);
                $builder->set("ins_date", $today);
                $builder->set("upd_id", $user_id);
                $builder->set("upd_date", $today);
                $result = $builder->insert();
            }

            $db->transComplete();
        } catch (Throwable $t) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            logMessage($t->getMessage());
            $db->transRollback();
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

        $rows = $data["rows"];
        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];
        $b_idx = $search_arr["b_idx"];

        // 오프셋 계산
        $offset = ($page-1)*$rows;
        if ($offset < 0) {
            $offset = 0;
        }

        $db = db_connect();
        $builder = $db->table("bulk_detail");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->limit($rows, $offset);
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

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

        $db = db_connect();
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

    // 게시판 입력
    public function procBulkUpdate($data)
    {
        // 게시판 입력과 관련된 기본 정보
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

        try {
            $db = db_connect();
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
            $db->transComplete();
        } catch (Throwable $t) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            logMessage($t->getMessage());
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

        try {
            $db = db_connect();
            $db->transStart();
            $builder = $db->table("bulk_detail");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $builder->where("bd_idx", $bd_idx);
            $result = $builder->update();
            $db->transComplete();
        } catch (Throwable $t) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            logMessage($t->getMessage());
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}
