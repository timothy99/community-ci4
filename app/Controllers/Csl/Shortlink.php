<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\ShortlinkModel;
use App\Models\Common\PagingModel;

class Shortlink extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $shortlink_model = new ShortlinkModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;

        $model_result = $shortlink_model->getShortlinkList($data);
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

        return aview("csl/shortlink/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $info = (object)array();
        $info->sl_idx = 0;
        $info->title = "";
        $info->http_link = "";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/shortlink/edit", $proc_result);
    }

    public function update()
    {
        $shortlink_model = new ShortlinkModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $sl_idx = $this->request->getPost("sl_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $http_link = $this->request->getPost("http_link", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($http_link == null) {
            $result = false;
            $message = "링크를 입력해주세요.";
        }

        $data = array();
        $data["sl_idx"] = $sl_idx;
        $data["title"] = $title;
        $data["http_link"] = $http_link;

        if ($result == true) {
            if ($sl_idx == 0) {
                $model_result = $shortlink_model->procShortlinkInsert($data);
            } else {
                $model_result = $shortlink_model->procShortlinkUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/shortlink/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $shortlink_model = new ShortlinkModel();

        $sl_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $shortlink_model->getShortlinkInfo($sl_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/shortlink/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $shortlink_model = new ShortlinkModel();

        $sl_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["sl_idx"] = $sl_idx;

        $model_result = $shortlink_model->procSlideDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/shortlink/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $shortlink_model = new ShortlinkModel();

        $s_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $shortlink_model->getShortlinkInfo($s_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/shortlink/edit", $proc_result);
    }

}
