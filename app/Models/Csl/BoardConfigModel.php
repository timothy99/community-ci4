<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Common\SecurityModel;

class BoardConfigModel extends Model
{
    public function getConfigList($data)
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
        $builder = $db->table("board_config");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("bc_idx", "desc");
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

    public function checkConfigInfo($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $board_id = $data["board_id"];
        $title = $data["title"];
        $category_yn = $data["category_yn"];
        $category = $data["category"];
        $base_rows = $data["base_rows"];
        $file_cnt = $data["file_cnt"];
        $file_upload_size_limit = $data["file_upload_size_limit"];
        $file_upload_size_total = $data["file_upload_size_total"];

        if ($board_id == null) {
            $result = false;
            $message = "게시판 아이디를 입력해주세요.";
        }

        $restrict_id_arr = ["manage", "config"];
        foreach($restrict_id_arr as $no => $val) {
            $restrict_position = strrpos($board_id, $val);
            if ($restrict_position > -1) {
                $result = false;
                $message = "사용이 불가한 아이디입니다. 다른 아이디를 입력해주세요.";
            }
        }

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($category_yn == "Y" && $category == null) {
            $result = false;
            $message = "카테고리를 입력해주세요.";
        }

        if ($base_rows == null) {
            $result = false;
            $message = "줄 수를 입력해주세요.";
        }

        if ($file_cnt == null) {
            $result = false;
            $message = "첨부파일수를 입력해주세요.";
        }

        if ($file_upload_size_limit == null) {
            $result = false;
            $message = "개별 최대용량을 입력해주세요.";
        }

        if ($file_upload_size_total == null) {
            $result = false;
            $message = "첨부 최대 용량 입력해주세요.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    public function getBoardNumber()
    {
        $security_model = new SecurityModel();

        $cnt = 1;
        while ($cnt == 1) {
            $random_board_number = $security_model->getRandomString(6, 4);
            $random_board_id = "board".$random_board_number;

            $db = $this->db;
            $builder = $db->table("board_config");
            $builder->select("count(*) as cnt");
            $builder->where("del_yn", "N");
            $builder->where("board_id", $random_board_id);
            $info = $builder->get()->getRow();
            $cnt = $info->cnt;
            if ($cnt == 0) {
                break;
            }
        }

        return $random_board_number;
    }

    public function getConfigInfo($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $bc_idx = $data["bc_idx"];

        $db = $this->db;
        $builder = $db->table("board_config");
        $builder->where("del_yn", "N");
        $builder->where("bc_idx", $bc_idx);
        $info = $builder->get()->getRow();

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->upd_date_txt = $date_model->convertTextToDate($info->upd_date, 1, 1);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procConfigInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";
        $insert_id = 0;

        $board_id = $data["board_id"];
        $title = $data["title"];
        $category = $data["category"];
        $category_yn = $data["category_yn"];
        $user_write = $data["user_write"];
        $base_rows = $data["base_rows"];
        $reg_date_yn = $data["reg_date_yn"];
        $file_cnt = $data["file_cnt"];
        $file_upload_size_limit = $data["file_upload_size_limit"];
        $file_upload_size_total = $data["file_upload_size_total"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board_config");
        $builder->set("board_id", $board_id);
        $builder->set("title", $title);
        $builder->set("category", $category);
        $builder->set("category_yn", $category_yn);
        $builder->set("user_write", $user_write);
        $builder->set("base_rows", $base_rows);
        $builder->set("reg_date_yn", $reg_date_yn);
        $builder->set("file_cnt", $file_cnt);
        $builder->set("file_upload_size_limit", $file_upload_size_limit);
        $builder->set("file_upload_size_total", $file_upload_size_total);
        $builder->set("del_yn", "N");
        $builder->set("ins_id", $user_id);
        $builder->set("ins_date", $today);
        $builder->set("upd_id", $user_id);
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

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

    public function procConfigUpdate($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $bc_idx = $data["bc_idx"];
        $board_id = $data["board_id"];
        $title = $data["title"];
        $category = $data["category"];
        $category_yn = $data["category_yn"];
        $user_write = $data["user_write"];
        $base_rows = $data["base_rows"];
        $reg_date_yn = $data["reg_date_yn"];
        $file_cnt = $data["file_cnt"];
        $file_upload_size_limit = $data["file_upload_size_limit"];
        $file_upload_size_total = $data["file_upload_size_total"];

        $category_arr = explode("||", $category);
        foreach($category_arr as $no => $val) {
            if ($val == null) {
                unset($category_arr[$no]);
            }
        }
        $category = implode("||", $category_arr);

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board_config");
        $builder->set("board_id", $board_id);
        $builder->set("title", $title);
        $builder->set("category", $category);
        $builder->set("category_yn", $category_yn);
        $builder->set("user_write", $user_write);
        $builder->set("base_rows", $base_rows);
        $builder->set("reg_date_yn", $reg_date_yn);
        $builder->set("file_cnt", $file_cnt);
        $builder->set("file_upload_size_limit", $file_upload_size_limit);
        $builder->set("file_upload_size_total", $file_upload_size_total);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("bc_idx", $bc_idx);
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

    public function procConfigDelete($data)
    {
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        // 삭제대상의 board 환경 정보 읽어오기
        $model_result = $this->getConfigInfo($data);
        $config_info = $model_result["info"];
        $board_id = $config_info->board_id;

        $bc_idx = $data["bc_idx"];

        $db = $this->db;
        $db->transStart();

        // 설정 삭제
        $builder = $db->table("board_config");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("bc_idx", $bc_idx);
        $result = $builder->update();

        // 게시판 게시물 삭제
        $builder = $db->table("board");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("board_id", $board_id);
        $result = $builder->update();

        // 게시물 댓글 삭제 서브쿼리 사용
        $sub_query = $db->table("board a");
        $sub_query->select("b.bc_idx");
        $sub_query->join("board_comment b", "a.b_idx = b.b_idx");
        $sub_query->where("a.board_id", $board_id);

        $builder = $db->table("board_comment c");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->whereIn("bc_idx", $sub_query);
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
