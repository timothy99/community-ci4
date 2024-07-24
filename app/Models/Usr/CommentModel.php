<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use Throwable;
use App\Models\Common\DateModel;

class CommentModel extends Model
{
    public function getCommentList($b_idx)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("board_comment");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        $builder->orderBy("bc_idx", "desc");
        $list = $builder->get()->getResult();

        foreach($list as $no => $val) {
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
            $list[$no]->comment = str_replace("&#13;&#10;", "<br>", $val->comment);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

    public function procCommentInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $b_idx = $data["b_idx"];
        $comment = $data["comment"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board_comment");
        $builder->set("b_idx", $b_idx);
        $builder->set("comment", $comment);
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

    public function procCommentDelete($bc_idx)
    {
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board_comment");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
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

    public function getCommentInfo($bc_idx)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("board_comment");
        $builder->where("del_yn", "N");
        $builder->where("bc_idx", $bc_idx);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procCommentUpdate($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $bc_idx = $data["bc_idx"];
        $comment = $data["comment"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("board_comment");
        $builder->set("comment", $comment);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("bc_idx", $bc_idx);
        $result = $builder->update();
        $db->transComplete();

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

        try {
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
