<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\PrivacyModel;
use App\Models\Common\PagingModel;
use App\Models\Common\DateModel;
use App\Models\Common\SpreadsheetModel;

class Privacy extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/member/list");
    }

    public function list()
    {
        $privacy_model = new PrivacyModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "member_id";
        $search_condition = $search_condition == "null" ? "" : $search_condition; // null 이라는 텍스트로 들어와서 처리 함

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

        $model_result = $privacy_model->getPrivacyList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/csl/privacy/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/privacy/list", $proc_result);
    }

}
