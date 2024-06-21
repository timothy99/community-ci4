<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\AskModel;
use App\Models\Common\PagingModel;

class Ask extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/slide/list");
    }

    public function list()
    {
        $ask_model = new AskModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "name";

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

        $model_result = $ask_model->getAskList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/ask/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/ask/list", $proc_result);
    }

    public function delete()
    {
        $ask_model = new AskModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $a_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["a_idx"] = $a_idx;

        $model_result = $ask_model->procAskDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/ask/list";

        return json_encode($proc_result);
    }

}
