<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Common\DownloadModel;
use Exception;

class PopupModel extends Model
{
    public function getPopupList($data)
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
        $builder = $db->table("popup");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("p_idx", "desc");
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

            $list[$no]->list_no = $cnt - $no - (($page - 1) * $rows);
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

    public function getPopupInfo($data)
    {
        $date_model = new DateModel();
        $download_model = new DownloadModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $p_idx = $data["p_idx"];

        $db = $this->db;
        $builder = $db->table("popup");
        $builder->where("del_yn", "N");
        $builder->where("p_idx", $p_idx);
        $info = $builder->get()->getRow();

        $info->popup_file_info = $download_model->getFileInfo($info->popup_file);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->start_date_txt = $date_model->convertTextToDate($info->start_date, 1, 10);
        $info->end_date_txt = $date_model->convertTextToDate($info->end_date, 1, 10);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procPopupInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $disabled_hours = $data["disabled_hours"];
        $http_link = $data["http_link"];
        $position_left = $data["position_left"];
        $position_top = $data["position_top"];
        $popup_width = $data["popup_width"];
        $popup_height = $data["popup_height"];
        $popup_file = $data["popup_file"];
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $display_yn = $data["display_yn"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("popup");
            $builder->set("title", $title);
            $builder->set("disabled_hours", $disabled_hours);
            $builder->set("http_link", $http_link);
            $builder->set("position_left", $position_left);
            $builder->set("position_top", $position_top);
            $builder->set("popup_width", $popup_width);
            $builder->set("popup_height", $popup_height);
            $builder->set("popup_file", $popup_file);
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

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
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

    // 게시판 입력
    public function procPopupUpdate($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $p_idx = $data["p_idx"];
        $title = $data["title"];
        $disabled_hours = $data["disabled_hours"];
        $http_link = $data["http_link"];
        $position_left = $data["position_left"];
        $position_top = $data["position_top"];
        $popup_width = $data["popup_width"];
        $popup_height = $data["popup_height"];
        $popup_file = $data["popup_file"];
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $display_yn = $data["display_yn"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("popup");
            $builder->set("title", $title);
            $builder->set("disabled_hours", $disabled_hours);
            $builder->set("http_link", $http_link);
            $builder->set("position_left", $position_left);
            $builder->set("position_top", $position_top);
            $builder->set("popup_width", $popup_width);
            $builder->set("popup_height", $popup_height);
            $builder->set("popup_file", $popup_file);
            $builder->set("start_date", $start_date);
            $builder->set("end_date", $end_date);
            $builder->set("display_yn", $display_yn);
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $builder->where("p_idx", $p_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
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

    // 게시판 삭제
    public function procPopupDelete($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $p_idx = $data["p_idx"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("popup");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $builder->where("p_idx", $p_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
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
