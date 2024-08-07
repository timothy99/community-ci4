<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class AskModel extends Model
{
    public function procAskInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $name = $data["name"];
        $contents = $data["contents"];
        $phone = $data["phone"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("ask");
        $builder->set("name", $name);
        $builder->set("contents", $contents);
        $builder->set("phone", $phone);
        $builder->set("ins_date", $today);
        $builder->set("upd_date", $today);
        $result = $builder->insert();
        $insert_id = $db->insertID();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

}
