<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use App\Models\Common\DateModel;

class BoardConfigModel extends Model
{
    public function getConfigInfo($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $board_id = $data["board_id"];

        $db = $this->db;
        $builder = $db->table("board_config");
        $builder->where("del_yn", "N");
        $builder->where("board_id", $board_id);
        $info = $builder->get()->getRow();

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->upd_date_txt = $date_model->convertTextToDate($info->upd_date, 1, 1);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

}
