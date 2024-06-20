<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class PopupModel extends Model
{
    public function getPopupList($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $today = date("YmdHis");

        $db = db_connect();
        $builder = $db->table("popup");
        $builder->where("del_yn", "N");
        $builder->where("display_yn", "Y");
        $builder->where("start_date <=", $today);
        $builder->where("end_date >=", $today);
        $list = $builder->get()->getResult();

        $layer_closed = getUserSessionInfo("layer_closed");
        foreach ($layer_closed as $no1 => $val1) {
            foreach ($list as $no2 => $val2) {
                if ($val1->p_idx == $val2->p_idx) {
                    unset($list[$no2]);
                }
            }
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

}
