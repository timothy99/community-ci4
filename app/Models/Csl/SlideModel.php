<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Common\FileModel;

class SlideModel extends Model
{
    public function getSlideList($data)
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
        $builder = $db->table("slide");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("s_idx", "desc");
        $builder->limit($rows, getOffset($page, $rows));
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();
        foreach ($list as $no => $val) {
            if ($no == 0) {
                $active_class = "active";
            } else {
                $active_class = "";
            }
            $list[$no]->active_class = $active_class;

            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
            $list[$no]->start_date_txt = $date_model->convertTextToDate($val->start_date, 1, 1);
            $list[$no]->end_date_txt = $date_model->convertTextToDate($val->end_date, 1, 1);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getSlideInfo($s_idx)
    {
        $date_model = new DateModel();
        $file_model = new FileModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("slide");
        $builder->where("del_yn", "N");
        $builder->where("s_idx", $s_idx);
        $info = $builder->get()->getRow();

        $info->slide_file_info = $file_model->getFileInfo($info->slide_file);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->start_date_txt = $date_model->convertTextToDate($info->start_date, 1, 1);
        $info->end_date_txt = $date_model->convertTextToDate($info->end_date, 1, 1);
        $info->contents = nl2br_only($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    // 게시판 입력
    public function procSlideInsert($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $contents = $data["contents"];
        $slide_file = $data["slide_file"];
        $order_no = $data["order_no"];
        $http_link = $data["http_link"];
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $display_yn = $data["display_yn"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("slide");
        $builder->set("title", $title);
        $builder->set("contents", $contents);
        $builder->set("slide_file", $slide_file);
        $builder->set("order_no", $order_no);
        $builder->set("http_link", $http_link);
        $builder->set("start_date", $start_date);
        $builder->set("end_date", $end_date);
        $builder->set("display_yn", $display_yn);
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

    // 게시판 입력
    public function procSlideUpdate($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $s_idx = $data["s_idx"];
        $title = $data["title"];
        $contents = $data["contents"];
        $slide_file = $data["slide_file"];
        $order_no = $data["order_no"];
        $http_link = $data["http_link"];
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $display_yn = $data["display_yn"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("slide");
        $builder->set("title", $title);
        $builder->set("contents", $contents);
        $builder->set("slide_file", $slide_file);
        $builder->set("order_no", $order_no);
        $builder->set("http_link", $http_link);
        $builder->set("start_date", $start_date);
        $builder->set("end_date", $end_date);
        $builder->set("display_yn", $display_yn);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("s_idx", $s_idx);
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
    public function procSlideDelete($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $s_idx = $data["s_idx"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("slide");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("s_idx", $s_idx);
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
