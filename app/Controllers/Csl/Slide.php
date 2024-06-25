<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\SlideModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;

class Slide extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/slide/list");
    }

    public function list()
    {
        $slide_model = new SlideModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;

        $model_result = $slide_model->getSlideList($data);
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

        return aview("csl/slide/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $info = (object)array();
        $info->s_idx = 0;
        $info->order_no = 0;
        $info->title = "";
        $info->contents = "";
        $info->slide_file = "";
        $info->http_link = "";
        $info->display_yn = "Y";
        $info->start_date_txt = "2000-01-01 00:00";
        $info->end_date_txt = "9999-12-31 23:59";
        $info->http_link = "";
        $info->slide_file_info = null;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/slide/edit", $proc_result);
    }

    public function update()
    {
        $slide_model = new SlideModel();
        $date_model = new DateModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $s_idx = $this->request->getPost("s_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $contents = $this->request->getPost("contents", FILTER_SANITIZE_SPECIAL_CHARS);
        $http_link = $this->request->getPost("http_link", FILTER_SANITIZE_SPECIAL_CHARS);
        $order_no = $this->request->getPost("order_no", FILTER_SANITIZE_SPECIAL_CHARS);
        $slide_file = $this->request->getPost("slide_file_hidden", FILTER_SANITIZE_SPECIAL_CHARS);
        $display_yn = $this->request->getPost("display_yn");
        $start_date_txt = $this->request->getPost("start_date").":00";
        $end_date_txt = $this->request->getPost("end_date").":59";

        $start_date = $date_model->convertTextToDate($start_date_txt, 2, 3);
        $end_date = $date_model->convertTextToDate($end_date_txt, 2, 3);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($slide_file == null) {
            $result = false;
            $message = "PC용 이미지 파일을 올려주세요.";
        }

        if ($http_link == null) {
            $result = false;
            $message = "링크를 입력해주세요.";
        }

        if ($order_no == null) {
            $result = false;
            $message = "정렬순서를 입력해주세요.";
        }

        $data = array();
        $data["s_idx"] = $s_idx;
        $data["title"] = $title;
        $data["contents"] = $contents;
        $data["slide_file"] = $slide_file;
        $data["order_no"] = $order_no;
        $data["http_link"] = $http_link;
        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["display_yn"] = $display_yn;

        if ($result == true) {
            if ($s_idx == 0) {
                $model_result = $slide_model->procSlideInsert($data);
            } else {
                $model_result = $slide_model->procSlideUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/slide/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $slide_model = new SlideModel();
        $date_model = new DateModel();
        $file_model = new FileModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $slide_model->getSlideInfo($s_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $info->slide_file_info = $file_model->getFileInfo($info->slide_file);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->start_date_txt = $date_model->convertTextToDate($info->start_date, 1, 1);
        $info->end_date_txt = $date_model->convertTextToDate($info->end_date, 1, 1);
        $info->contents = nl2br_only($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/slide/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $slide_model = new SlideModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["s_idx"] = $s_idx;

        $model_result = $slide_model->procSlideDelete($data);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/slide/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $slide_model = new SlideModel();
        $file_model = new FileModel();
        $date_model = new DateModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $slide_model->getSlideInfo($s_idx);
        $info = $model_result["info"];

        $info->slide_file_info = $file_model->getFileInfo($info->slide_file);
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->start_date_txt = $date_model->convertTextToDate($info->start_date, 1, 10);
        $info->end_date_txt = $date_model->convertTextToDate($info->end_date, 1, 10);
        $info->contents = nl2br_rn($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/slide/edit", $proc_result);
    }

}
