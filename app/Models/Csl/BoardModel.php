<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Csl\MemberModel;
use App\Models\Common\DownloadModel;
use Exception;

class BoardModel extends Model
{
    public function getBoardList($data)
    {
        $date_model = new DateModel();
        $member_model = new MemberModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];
        $board_id = $data["board_id"];
        $notice_yn = $data["notice_yn"];
        $reg_date_yn = $data["reg_date_yn"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];
        $category = $search_arr["category"];

        $db = $this->db;
        $builder = $db->table("board");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        if ($category != null) {
            $builder->where("category", $category);
        }
        $builder->where("board_id", $board_id);
        $builder->where("notice_yn", $notice_yn);

        if ($reg_date_yn == "Y") {
            $builder->orderBy("reg_date", "desc");
        } else {
            $builder->orderBy("b_idx", "desc");
        }

        $builder->limit($rows, getOffset($page, $rows));
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
            $list[$no]->reg_date_txt = $date_model->convertTextToDate($val->reg_date, 1, 1);
            $list[$no]->member_info = $member_model->getMemberInfo($val->ins_id)["info"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getConfigInfo($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $board_id = $data["board_id"];

        $db = $this->db;
        $builder = $db->table("board_config");
        $builder->where("del_yn", "N");
        $builder->where("board_id", $board_id);
        $info = $builder->get()->getRow();
        $info->category_arr = explode("||", $info->category);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function getBoardInfo($data)
    {
        $date_model = new DateModel();
        $member_model = new MemberModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $b_idx = $data["b_idx"];

        $db = $this->db;
        $builder = $db->table("board");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        $info = $builder->get()->getRow();

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->reg_date_txt = $date_model->convertTextToDate($info->reg_date, 1, 1);
        $info->member_info = $member_model->getMemberInfo($info->ins_id)["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function getBoardFileList($data)
    {
        $result = true;
        $message = "파일목록을 잘 불러왔습니다";

        $download_model = new DownloadModel();

        $info = $data["info"];

        $file_arr = strlen($info->file_idxs) > 0 ? explode("|", $info->file_idxs) : array();
        $file_list = array();
        if (count($file_arr) > 0) {
            foreach($file_arr as $no => $val) {
                $file_info = $download_model->getFileInfo($val);
                $file_list[] = $file_info;
            }
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["list"] = $file_list;

        return $model_result;
    }

    // 게시판 입력
    public function procBoardInsert($data)
    {
        $date_model = new DateModel();

        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";
        $insert_id = 0;

        $title = $data["title"];
        $contents = $data["contents"];
        $board_id = $data["board_id"];
        $file_list = $data["file_list"];
        $category = $data["category"];
        $notice_yn = $data["notice_yn"];
        $reg_date = $data["reg_date"];

        if (count($file_list) > 0) {
            $file_idxs = implode("|", $file_list);
        } else {
            $file_idxs = null;
        }

        $reg_date = $date_model->convertTextToDate($reg_date, 2, 3);

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("board");
            $builder->set("board_id", $board_id);
            $builder->set("title", $title);
            $builder->set("contents", $contents);
            $builder->set("file_idxs", $file_idxs);
            $builder->set("category", $category);
            $builder->set("notice_yn", $notice_yn);
            $builder->set("reg_date", $reg_date);
            $builder->set("del_yn", "N");
            $builder->set("ins_id", $user_id);
            $builder->set("ins_date", $today);
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $result = $builder->insert();
            $insert_id = $db->insertID();

            if ($result == false) { 
                throw new Exception($db->error()["message"]);
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

    public function procBoardUpdate($data)
    {
        $date_model = new DateModel();

        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $contents = $data["contents"];
        $b_idx = $data["b_idx"];
        $board_id = $data["board_id"];
        $file_list = $data["file_list"];
        $category = $data["category"];
        $notice_yn = $data["notice_yn"];
        $reg_date = $data["reg_date"];

        if (count($file_list) > 0) {
            $file_idxs = implode("|", $file_list);
        } else {
            $file_idxs = null;
        }

        $reg_date = $date_model->convertTextToDate($reg_date, 2, 3);

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("board");
            $builder->set("board_id", $board_id);
            $builder->set("title", $title);
            $builder->set("contents", $contents);
            $builder->set("file_idxs", $file_idxs);
            $builder->set("category", $category);
            $builder->set("notice_yn", $notice_yn);
            $builder->set("reg_date", $reg_date);
            $builder->set("del_yn", "N");
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $builder->where("b_idx", $b_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error()["message"]);
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    public function procBoardDelete($data)
    {
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $b_idx = $data["b_idx"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("board");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $builder->where("b_idx", $b_idx);
            $result = $builder->update();

            $builder = $db->table("board_comment");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $builder->where("b_idx", $b_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error()["message"]);
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}

