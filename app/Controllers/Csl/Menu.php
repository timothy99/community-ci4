<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\MenuModel;

class Menu extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $menu_model = new MenuModel();

        $model_result = $menu_model->getMenuList();
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return aview("csl/menu/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $upper_idx = $this->request->getUri()->getSegment(4, 0);

        $info = (object)array();
        $info->m_idx = 0;
        $info->upper_idx = $upper_idx;
        $info->idx1  = 0;
        $info->idx2  = 0;
        $info->idx3  = 0;
        $info->menu_position = 0;
        $info->menu_name  = "";
        $info->order_no  = "";
        $info->http_link  = "";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/menu/edit", $proc_result);
    }

    public function update()
    {
        $menu_model = new MenuModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $m_idx = $this->request->getPost("m_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $upper_idx = $this->request->getPost("upper_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $idx1 = $this->request->getPost("idx1", FILTER_SANITIZE_SPECIAL_CHARS);
        $idx2 = $this->request->getPost("idx2", FILTER_SANITIZE_SPECIAL_CHARS);
        $idx3 = (string)$this->request->getPost("idx3", FILTER_SANITIZE_SPECIAL_CHARS);
        $menu_position = $this->request->getPost("menu_position", FILTER_SANITIZE_SPECIAL_CHARS);
        $menu_name = $this->request->getPost("menu_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $http_link = $this->request->getPost("http_link", FILTER_SANITIZE_SPECIAL_CHARS);
        $order_no = $this->request->getPost("order_no", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["m_idx"] = $m_idx;
        $data["upper_idx"] = $upper_idx;
        $data["idx1"] = $idx1;
        $data["idx2"] = $idx2;
        $data["idx3"] = $idx3;
        $data["menu_position"] = $menu_position;
        $data["menu_name"] = $menu_name;
        $data["http_link"] = $http_link;
        $data["order_no"] = $order_no;
        $model_result = $menu_model->checkMenuInfo($data);

        if ($result == true) {
            if ($m_idx == 0) {
                $model_result = $menu_model->procMenuInsert($data);
                $m_idx = $model_result["insert_id"];
            } else {
                $model_result = $menu_model->procMenuUpdate($data);
            }
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        // 메뉴 업데이트 후 메뉴에 대한 json을 만들어서 메뉴불러오는데 지나치게 많은 쿼리를 실행하는걸 막는다.
        if ($result == true) {
            $model_result = $menu_model->procMenuJsonInsert($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["m_idx"] = $m_idx;
        $proc_result["return_url"] = "/csl/menu/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $menu_model = new MenuModel();

        $result = true;
        $message = "정상";

        $m_idx = $this->request->getUri()->getSegment(4, 0);

        $data = array();
        $data["m_idx"] = $m_idx;

        $model_result = $menu_model->getMenuInfo($data);
        $info = $model_result["info"];
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/menu/edit", $proc_result);
    }

    public function delete()
    {
        $menu_model = new MenuModel();

        $result = true;
        $message = "정상";

        $m_idx = $this->request->getUri()->getSegment(4, 0);

        $data = array();
        $data["m_idx"] = $m_idx;
        $model_result = $menu_model->procMenuDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/menu/list";

        return json_encode($proc_result);
    }

}
