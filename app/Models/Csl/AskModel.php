<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use Exception;

class AskModel extends Model
{
    public function getAskList($data)
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
        $builder = $db->table("ask");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("a_idx", "desc");
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

    public function procAskDelete($data)
    {
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $a_idx = $data["a_idx"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("ask");
            $builder->set("del_yn", "Y");
            $builder->set("upd_date", $today);
            $builder->where("a_idx", $a_idx);
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
