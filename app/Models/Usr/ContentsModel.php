<?php

namespace App\Models\Csl;

use CodeIgniter\Model;

class ContentsModel extends Model
{
    public function getContentsInfo($c_idx)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("contents");
        $builder->where("del_yn", "N");
        $builder->where("c_idx", $c_idx);
        $info = $builder->get()->getRow();

        $info->contents = nl2br_only($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

}
