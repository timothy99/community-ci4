<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use Throwable;
use App\Models\Common\DateModel;

class BoardModel extends Model
{
    public function getBoardList($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $rows = $data["rows"];
        $page = $data["page"];
        $board_id = $data["board_id"];
        $search_arr = $data["search_arr"];

        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        // 오프셋 계산
        $offset = ($page-1)*$rows;
        if ($offset < 0) {
            $offset = 0;
        }

        $db = db_connect();
        $builder = $db->table("mng_board");
        $builder->select("*");
        $builder->where("board_id", $board_id);
        $builder->where("del_yn", "N");

        if ($search_text != null) {
            $builder->where($search_condition, $search_text);
        }

        $builder->orderBy("b_idx", "desc");
        $builder->limit($rows, $offset);
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        $start_row = ($page-1)*$rows;
        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$start_row-$no;
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getBoardInfo($b_idx)
    {
        $result = true;
        $message = "정상처리";

        $db = db_connect();
        $builder = $db->table("mng_board");
        $builder->select("*");
        $builder->where("del_yn", "N");
        $builder->where("b_idx", $b_idx);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

}
