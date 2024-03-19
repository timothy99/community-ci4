<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use Throwable;

class BoardModel extends Model
{
    public function getBoardList($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $rows = $data["rows"];
        $page = $data["page"];
        $search_arr = $data["search_arr"];

        // 오프셋 계산
        $offset = ($page-1)*$rows;
        if ($offset < 0) {
            $offset = 0;
        }

        $db = db_connect();
        $builder = $db->table("mng_board");
        $builder->select("*");
        $builder->where("del_yn", "N");
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

}
