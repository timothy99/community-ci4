<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class ShortlinkModel extends Model
{
    public function getShortlinkInfo($sl_idx)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("shortlink");
        $builder->where("del_yn", "N");
        $builder->where("sl_idx", $sl_idx);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

}
