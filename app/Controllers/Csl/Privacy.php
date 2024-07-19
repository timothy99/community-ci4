<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\PrivacyModel;
use App\Models\Common\PagingModel;

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

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "member_id";

        $data["search_arr"] = $search_arr;

        $model_result = $privacy_model->getPrivacyList($data);
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

        return aview("csl/privacy/list", $proc_result);
    }

}
