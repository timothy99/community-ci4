<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Common\DownloadModel;

class BoardModel extends Model
{
    public function getBoardList($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];
        $board_id = $data["board_id"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        $db = $this->db;
        $builder = $db->table("board");
        $builder->where("board_id", $board_id);
        $builder->where("del_yn", "N");

        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }

        $builder->orderBy("b_idx", "desc");
        $builder->limit($rows, getOffset($page, $rows));
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        $start_row = ($page-1)*$rows;
        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$start_row-$no;
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
            $list[$no]->file_arr = explode("|", $val->file_idxs);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getBoardInfo($data)
    {
        $date_model = new DateModel();
        $download_model = new DownloadModel();

        $result = true;
        $message = "정상처리";

        $b_idx = $data["b_idx"];

        $db = $this->db;
        $builder = $db->table("board");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        $info = $builder->get()->getRow();

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);

        $file_arr = strlen($info->file_idxs) > 0 ? explode("|", $info->file_idxs) : array();
        $file_list = array();
        if (count($file_arr) > 0) {
            foreach($file_arr as $no => $val) {
                $file_info = $download_model->getFileInfo($val);
                $file_list[] = $file_info;
            }
        }

        $info->file_list = $file_list;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procBoardInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $contents = $data["contents"];
        $board_id = $data["board_id"];
        $file_idxs = $data["file_idxs"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board");
        $builder->set("board_id", $board_id);
        $builder->set("title", $title);
        $builder->set("contents", $contents);
        $builder->set("file_idxs", $file_idxs);
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

    public function procBoardUpdate($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $contents = $data["contents"];
        $b_idx = $data["b_idx"];
        $board_id = $data["board_id"];
        $file_idxs = $data["file_idxs"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board");
        $builder->set("board_id", $board_id);
        $builder->set("title", $title);
        $builder->set("contents", $contents);
        $builder->set("file_idxs", $file_idxs);
        $builder->set("del_yn", "N");
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("b_idx", $b_idx);
        $builder->where("ins_id", $user_id);
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

    public function procBoardDelete($b_idx)
    {
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("b_idx", $b_idx);
        $builder->where("ins_id", $member_id);
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

}
