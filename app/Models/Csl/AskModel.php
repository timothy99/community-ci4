<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use Throwable;

class AskModel extends Model
{
    public function getAskList($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $rows = $data["rows"];
        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        // 오프셋 계산
        $offset = ($page-1)*$rows;
        if ($offset < 0) {
            $offset = 0;
        }

        $db = db_connect();
        $builder = $db->table("ask");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("a_idx", "desc");
        $builder->limit($rows, $offset);
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    // 게시판 삭제
    public function procAskDelete($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $a_idx = $data["a_idx"];

        try {
            $db = db_connect();
            $db->transStart();
            $builder = $db->table("ask");
            $builder->set("del_yn", "Y");
            $builder->set("upd_date", $today);
            $builder->where("a_idx", $a_idx);
            $result = $builder->update();
            $db->transComplete();
        } catch (Throwable $t) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            logMessage($t->getMessage());
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}
