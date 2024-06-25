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

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "name";

        $data["search_arr"] = $search_arr;

        $model_result = $ask_model->getAskList($data);
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
