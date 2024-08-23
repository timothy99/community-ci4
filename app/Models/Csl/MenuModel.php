<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use Exception;

class MenuModel extends Model
{
    // 메뉴리스트 생성
    public function getMenuList()
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        // upper_idx 기준으로 상위 데이터를 찾아본다.
        $db = $this->db;
        $builder = $db->table("menu");
        $builder->where("del_yn", "N");
        $builder->where("upper_idx", 0);
        $builder->orderBy("order_no", "asc");
        $list = $builder->get()->getResult();
        foreach($list as $no => $val) {
            $m_idx = $val->m_idx;
            $builder = $db->table("menu");
            $builder->where("del_yn", "N");
            $builder->where("upper_idx", $m_idx);
            $builder->orderBy("order_no", "asc");
            $list2 = $builder->get()->getResult();
            $list[$no]->list = $list2;
            foreach($list2 as $no2 => $val2) {
                $m_idx = $val2->m_idx;
                $builder = $db->table("menu");
                $builder->where("del_yn", "N");
                $builder->where("upper_idx", $m_idx);
                $builder->orderBy("order_no", "asc");
                $list3 = $builder->get()->getResult();
                $list[$no]->list[$no2]->list = $list3;
            }
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

    // 메뉴 생성시 정합성 체크
    public function checkMenuInfo($data)
    {
        $result = true;
        $message = "정합성 체크가 완료되었습니다.";

        $menu_name = $data["menu_name"];
        $http_link = $data["http_link"];
        $order_no = $data["order_no"];

        if ($menu_name == null) {
            $result = false;
            $message = "메뉴명 입력해주세요.";
        }

        if ($http_link == null) {
            $result = false;
            $message = "링크를 입력해주세요.";
        }

        if ($order_no == null || $order_no < 1) {
            $result = false;
            $message = "정렬순서를 입력해주세요.";
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

    public function procMenuInsert($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $m_idx = $data["m_idx"];
        $upper_idx = $data["upper_idx"];
        $idx1 = $data["idx1"];
        $idx2 = $data["idx2"];
        $idx3 = $data["idx3"];
        $menu_position = $data["menu_position"];
        $menu_name = $data["menu_name"];
        $http_link = $data["http_link"];
        $order_no = $data["order_no"];

        $menu_position = 1;
        $new_menu_position = 1;

        $input_data = array();
        $input_data["m_idx"] = $upper_idx;
        $model_result = $this->getMenuInfo($input_data);
        $info = $model_result["info"];
        if ($info != null) {
            $idx1 = $info->idx1;
            $idx2 = $info->idx2;
            $idx3 = $info->idx3;
            $menu_position = $info->menu_position;
            $new_menu_position = $menu_position + 1;
        }

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("menu");
            $builder->set("upper_idx", $upper_idx);
            $builder->set("idx1", $idx1);
            $builder->set("idx2", $idx2);
            $builder->set("idx3", $idx3);
            $builder->set("menu_position", $new_menu_position);
            $builder->set("menu_name", $menu_name);
            $builder->set("http_link", $http_link);
            $builder->set("order_no", $order_no);
            $builder->set("del_yn", "N");
            $builder->set("ins_id", $user_id);
            $builder->set("ins_date", $today);
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $result = $builder->insert();
            $insert_id = $db->insertID();

            $builder = $db->table("menu");
            $builder->set("idx".$new_menu_position, $insert_id);
            $builder->where("m_idx", $insert_id);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

    public function getMenuInfo($data)
    {
        $date_model = new DateModel();

        $m_idx = $data["m_idx"];

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $db = $this->db;
        $builder = $db->table("menu");
        $builder->where("del_yn", "N");
        $builder->where("m_idx", $m_idx);
        $info = $builder->get()->getRow();

        if ($info != null) {
            $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function procMenuUpdate($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $m_idx = $data["m_idx"];
        $menu_name = $data["menu_name"];
        $http_link = $data["http_link"];
        $order_no = $data["order_no"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("menu");
            $builder->set("menu_name", $menu_name);
            $builder->set("http_link", $http_link);
            $builder->set("order_no", $order_no);
            $builder->set("ins_id", $user_id);
            $builder->set("ins_date", $today);
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $builder->where("m_idx", $m_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    public function procMenuDelete($data)
    {
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $m_idx = $data["m_idx"];

        try {
            $db = $this->db;
            $db->transStart();
            $builder = $db->table("menu");
            $builder->set("del_yn", "Y");
            $builder->set("upd_id", $user_id);
            $builder->set("upd_date", $today);
            $builder->orWhere("idx1", $m_idx);
            $builder->orWhere("idx2", $m_idx);
            $builder->orWhere("idx3", $m_idx);
            $result = $builder->update();

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    /**
     * [Description for procMenuJsonInsert]
     *
     * 생성된 메뉴를 json으로 정리한다.
     * 향후 사용자, 관리자등 권한이 많아질 경우를 대비해 data는 사용하지 않더라도 변수는 있음
     *
     * @param array $data
     *
     * @return $proc_result array
     *
     * @author timothy99
     */
    public function procMenuJsonInsert($data)
    {
        $menu_model = new MenuModel();

        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $model_result = $menu_model->getMenuList();
        $list = $model_result["list"];
        $menu_json = json_encode($list);

        try {
            $db = $this->db;
            $db->transStart();

            $builder = $db->table("menu_json");
            $builder->where("category", "user");
            $builder->where("del_yn", "N");
            $list = $builder->get()->getResult();
            $cnt = count($list);
            if ($cnt == 0) {
                $builder = $db->table("menu_json");
                $builder->set("menu_json", $menu_json);
                $builder->set("category", "user");
                $builder->set("del_yn", "N");
                $builder->set("ins_id", $user_id);
                $builder->set("ins_date", $today);
                $builder->set("upd_id", $user_id);
                $builder->set("upd_date", $today);
                $builder->where("category", "user");
                $result = $builder->insert();
            } else {
                $builder = $db->table("menu_json");
                $builder->set("menu_json", $menu_json);
                $builder->set("category", "user");
                $builder->set("upd_id", $user_id);
                $builder->set("upd_date", $today);
                $builder->where("category", "user");
                $result = $builder->update();
            }

            if ($result == false) { 
                throw new Exception($db->error(["message"]));
            } else {
                $db->transComplete();
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}
