<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\BoardModel;
use App\Models\Common\PagingModel;

class Board extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/board/notice/list");
    }

    public function list()
    {
        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[1];

        $board_model = new BoardModel();
        $paging_model = new PagingModel();

        $rows = 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $search_condition == "null" ? "" : $search_condition; // null 이라는 텍스트로 들어와서 처리 함

        $search_arr = array();
        $search_arr["search_text"] = $search_text;
        $search_arr["search_condition"] = $search_condition;
        $search_arr["page"] = $page;
        $http_query = http_build_query($search_arr);

        $data = array();
        $data["rows"] = $rows;
        $data["page"] = $page;
        $data["search_arr"] = $search_arr;
        $data["board_id"] = $board_id;

        $model_result = $board_model->getBoardList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/board/".$board_id."/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["page"] = $page;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["board_id"] = $board_id;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/board/list", $proc_result);
    }

    public function write()
    {
        // do something...
    }

    public function edit()
    {
        // do something...
    }

}
