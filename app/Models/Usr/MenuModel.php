<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class MenuModel extends Model
{
    // 메뉴리스트 생성
    public function getMenuList()
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("menu_json");
        $builder->where("category", "user");
        $builder->where("del_yn", "N");
        $info = $builder->get()->getRow();
        $menu_json = $info->menu_json;
        $list = json_decode($menu_json);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

}
