<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use Throwable;

class SlideModel extends Model
{
    public function getSlideList($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $today = date("YmdHis");

        $db = db_connect();
        $builder = $db->table("slide");
        $builder->where("del_yn", "N");
        $builder->where("display_yn", "Y");
        $builder->where("start_date <=", $today);
        $builder->where("end_date >=", $today);
        $builder->orderBy("order_no", "asc");
        $list = $builder->get()->getResult();
        foreach ($list as $no => $val) {
            if ($no == 0) {
                $active_class = "active";
            } else {
                $active_class = "";
            }
            $list[$no]->active_class = $active_class;
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

}
