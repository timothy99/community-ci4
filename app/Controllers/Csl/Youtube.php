<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\YoutubeModel;
use App\Models\Common\PagingModel;

class Youtube extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $youtube_model = new YoutubeModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;

        $model_result = $youtube_model->getPlayList($data);
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

        return aview("csl/youtube/list", $proc_result);
    }

    public function write()
    {
        $result = true;
        $message = "정상";

        $info = (object)array();
        $info->y_idx = 0;
        $info->title = "";
        $info->category = "channel";
        $info->play_id = "";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/youtube/edit", $proc_result);
    }

    public function update()
    {
        $youtube_model = new YoutubeModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $y_idx = $this->request->getPost("y_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $category = $this->request->getPost("category", FILTER_SANITIZE_SPECIAL_CHARS);
        $play_id = $this->request->getPost("play_id", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        $data = array();
        $data["y_idx"] = $y_idx;
        $data["title"] = $title;
        $data["category"] = $category;
        $data["play_id"] = $play_id;

        if ($result == true) {
            if ($y_idx == 0) {
                $model_result = $youtube_model->procPlaylistInsert($data);
            } else {
                $model_result = $youtube_model->procPlaylistUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/youtube/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $youtube_model = new YoutubeModel();

        $y_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $data = array();
        $data["y_idx"] = $y_idx;

        $model_result = $youtube_model->getPlaylistInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $model_result = $youtube_model->getVideoList($info);
        $result = $model_result["result"];
        $list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;
        $proc_result["list"] = $list;

        return aview("csl/youtube/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $youtube_model = new YoutubeModel();

        $y_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["y_idx"] = $y_idx;

        $model_result = $youtube_model->procPlaylistDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/youtube/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $youtube_model = new YoutubeModel();

        $y_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $data = array();
        $data["y_idx"] = $y_idx;

        $model_result = $youtube_model->getPlaylistInfo($data);
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/youtube/edit", $proc_result);
    }

    public function search()
    {
        $youtube_model = new YoutubeModel();

        $result = true;
        $message = "데이터가 없습니다.";
        $list = array();

        $search_text = $this->request->getGet("search_text");

        $data = array();
        $data["search_text"] = $search_text;
        if ($search_text != null) {
            $model_result = $youtube_model->getSearchList($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
            $list = $model_result["list"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["data"] = $data;

        return aview("csl/youtube/search", $proc_result);
    }

}
