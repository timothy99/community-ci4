<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\ContentsModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;

class Contents extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/contents/list");
    }

    public function list()
    {
        $contents_model = new ContentsModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $search_arr = array();
        $search_arr["search_text"] = $search_text;
        $search_arr["search_condition"] = $search_condition;
        $search_arr["page"] = $page;
        $search_arr["rows"] = $rows;
        $http_query = http_build_query($search_arr);

        $data = array();
        $data["rows"] = $rows;
        $data["page"] = $page;
        $data["search_arr"] = $search_arr;

        $model_result = $contents_model->getContentsList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/csl/contents/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/contents/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $info = (object)array();
        $info->c_idx = 0;
        $info->title = "";
        $info->contents = "&nbsp;";
        $info->contents_code = "&nbsp;";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/contents/edit", $proc_result);
    }

    public function update()
    {
        $contents_model = new ContentsModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $c_idx = $this->request->getPost("c_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $summer_code = (string)$this->request->getPost("summer_code");
        $summer_code = str_replace("<p><br></p><p>", "", $summer_code);
        $summer_code = str_replace("\r\n", "", $summer_code);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        $data = array();
        $data["c_idx"] = $c_idx;
        $data["title"] = $title;
        $data["contents"] = $summer_code;

        if ($result == true) {
            if ($c_idx == 0) {
                $model_result = $contents_model->procContentsInsert($data);
            } else {
                $model_result = $contents_model->procContentsUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/contents/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $contents_model = new ContentsModel();
        $date_model = new DateModel();

        $c_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $contents_model->getContentsInfo($c_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);
        $info->contents = nl2br_only($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/contents/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $contents_model = new ContentsModel();

        $c_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["c_idx"] = $c_idx;

        $model_result = $contents_model->procContentsDelete($data);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/contents/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $contents_model = new ContentsModel();

        $c_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $contents_model->getContentsInfo($c_idx);
        $info = $model_result["info"];

        $info->contents = nl2br_rn($info->contents);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/contents/edit", $proc_result);
    }

}
