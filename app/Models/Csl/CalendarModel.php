<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use App\Models\Common\DownloadModel;
use Exception;

class CalendarModel extends Model
{
    // 일정 목록
    public function getCalendarList($data)
    {
        $date_model = new DateModel();

        $start_date = $data["start_date"];
        $end_date = $data["end_date"];

        $db_result = true;
        $db_message = "조회에 성공했습니다.";

        $db = $this->db;
        $builder = $db->table("calendar");
        $builder->where("del_yn", "N");
        $builder->groupStart();
        $builder->where("start_date <=", $end_date);
        $builder->where("end_date >=", $start_date);
        $builder->groupEnd();
        $list = $builder->get()->getResult();

        foreach ($list as $no => $val) {
            $list[$no]->id = $val->c_idx;
            $list[$no]->title = htmlspecialchars_decode($val->title);
            $list[$no]->start = $date_model->convertTextToDate($val->start_date, 1, 12);
            $list[$no]->end = $date_model->convertTextToDate($val->end_date, 1, 12);
        }

        $model_result = array();
        $model_result["result"] = $db_result;
        $model_result["message"] = $db_message;
        $model_result["list"] = $list;

        return $model_result;
    }

    // 캘린더 입력
    public function procCalendarInsert($data)
    {
        $date_model = new DateModel();

        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";
        $insert_id = 0;

        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $title = $data["title"];
        $contents = $data["contents"];
        $attach_file = $data["attach_file"];

        $start_date = $date_model->convertTextToDate($start_date, 8, 3);
        $end_date = $date_model->convertTextToDate($end_date, 8, 3);

        $db = $this->db;
        try {
            $builder = $db->table("calendar");
            $builder->set("start_date", $start_date);
            $builder->set("end_date", $end_date);
            $builder->set("title", $title);
            $builder->set("contents", $contents);
            $builder->set("attach_file", $attach_file);
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

    // 일정 목록
    public function getCalendarInfo($data)
    {
        $date_model = new DateModel();
        $download_model = new DownloadModel();

        $c_idx = $data["c_idx"];

        $db_result = true;
        $db_message = "조회에 성공했습니다.";

        $db = $this->db;
        $builder = $db->table("calendar");
        $builder->where("del_yn", "N");
        $builder->where("c_idx", $c_idx);
        $info = $builder->get()->getRow();

        $info->id = $info->c_idx;
        $info->title = htmlspecialchars_decode($info->title);
        $info->start = $date_model->convertTextToDate($info->start_date, 1, 1);
        $info->end = $date_model->convertTextToDate($info->end_date, 1, 1);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->attach_file_info = $download_model->getFileInfo($info->attach_file);

        $model_result = array();
        $model_result["result"] = $db_result;
        $model_result["message"] = $db_message;
        $model_result["info"] = $info;

        return $model_result;
    }

    // 캘린더 입력
    public function procCalendarUpdate($data)
    {
        $date_model = new DateModel();

        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $c_idx = $data["c_idx"];
        $start_date = $data["start_date"];
        $end_date = $data["end_date"];
        $title = $data["title"];
        $contents = $data["contents"];
        $attach_file = $data["attach_file"];

        $start_date = $date_model->convertTextToDate($start_date, 8, 3);
        $end_date = $date_model->convertTextToDate($end_date, 8, 3);

        $db = $this->db;
        try {
            $builder = $db->table("calendar");
            $builder->set("start_date", $start_date);
            $builder->set("end_date", $end_date);
            $builder->set("title", $title);
            $builder->set("contents", $contents);
            $builder->set("attach_file", $attach_file);
            $builder->set("del_yn", "N");
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $builder->where("c_idx", $c_idx);
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

    public function procCalendarDelete($data)
    {
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $c_idx = $data["c_idx"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("calendar");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $member_id);
            $builder->set("upd_date", $today);
            $builder->where("c_idx", $c_idx);
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
