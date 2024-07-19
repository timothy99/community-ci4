<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\PopupModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;

class Popup extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/popup/list");
    }

    public function list()
    {
        $popup_model = new PopupModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;

        $model_result = $popup_model->getPopupList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        $data["cnt"] = $cnt;
        $paging_info = $paging_model->getPagingInfo($data);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging_info"] = $paging_info;
        $proc_result["data"] = $data;

        return aview("csl/popup/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $info = (object)array();
        $info->p_idx = 0;
        $info->order_no = 0;
        $info->title = "";
        $info->popup_file = "";
        $info->http_link = "";
        $info->display_yn = "Y";
        $info->start_date_txt = "2000-01-01 00:00";
        $info->end_date_txt = "9999-12-31 23:59";
        $info->disabled_hours = "24";
        $info->position_left = "50";
        $info->position_top = "70";
        $info->popup_width = "400";
        $info->popup_height = "500";
        $info->popup_file_info = null;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/popup/edit", $proc_result);
    }

    public function update()
    {
        $popup_model = new PopupModel();
        $date_model = new DateModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $p_idx = $this->request->getPost("p_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $disabled_hours = $this->request->getPost("disabled_hours", FILTER_SANITIZE_SPECIAL_CHARS);
        $http_link = $this->request->getPost("http_link", FILTER_SANITIZE_SPECIAL_CHARS);
        $position_left = (int)$this->request->getPost("position_left");
        $position_top = (int)$this->request->getPost("position_top");
        $popup_width = (int)$this->request->getPost("popup_width");
        $popup_height = (int)$this->request->getPost("popup_height");
        $popup_file = $this->request->getPost("popup_file_hidden", FILTER_SANITIZE_SPECIAL_CHARS);
        $display_yn = $this->request->getPost("display_yn");
        $start_date_txt = $this->request->getPost("start_date").":00";
        $end_date_txt = $this->request->getPost("end_date").":59";

        $start_date = $date_model->convertTextToDate($start_date_txt, 2, 3);
        $end_date = $date_model->convertTextToDate($end_date_txt, 2, 3);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($popup_file == null) {
            $result = false;
            $message = "PC용 이미지 파일을 올려주세요.";
        }

        if ($http_link == null) {
            $result = false;
            $message = "링크를 입력해주세요.";
        }

        $data = array();
        $data["p_idx"] = $p_idx;
        $data["title"] = $title;
        $data["disabled_hours"] = $disabled_hours;
        $data["http_link"] = $http_link;
        $data["position_left"] = $position_left;
        $data["position_top"] = $position_top;
        $data["popup_width"] = $popup_width;
        $data["popup_height"] = $popup_height;
        $data["popup_file"] = $popup_file;
        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["display_yn"] = $display_yn;

        if ($result == true) {
            if ($p_idx == 0) {
                $model_result = $popup_model->procPopupInsert($data);
            } else {
                $model_result = $popup_model->procPopupUpdate($data);
            }
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/popup/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $popup_model = new PopupModel();

        $p_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $popup_model->getPopupInfo($p_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/popup/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $popup_model = new PopupModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["s_idx"] = $s_idx;

        $model_result = $popup_model->procPopupDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/popup/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $popup_model = new PopupModel();
        $file_model = new FileModel();
        $date_model = new DateModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $popup_model->getPopupInfo($s_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $info->popup_file_info = $file_model->getFileInfo($info->popup_file);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->start_date_txt = $date_model->convertTextToDate($info->start_date, 1, 10);
        $info->end_date_txt = $date_model->convertTextToDate($info->end_date, 1, 10);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/popup/edit", $proc_result);
    }

}
