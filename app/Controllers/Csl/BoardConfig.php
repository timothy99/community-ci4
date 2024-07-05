<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\BoardConfigModel;
use App\Models\Csl\CommentModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;

class BoardConfig extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $config_model = new BoardConfigModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;

        $model_result = $config_model->getConfigList($data);
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

        return aview("csl/board/config/list", $proc_result);
    }

    public function write()
    {
        $config_model = new BoardConfigModel();

        $result = true;
        $message = "정상";

        $random_board_number = $config_model->getBoardNumber();

        $info = (object)array();
        $info->bc_idx = 0;
        $info->board_id = "board".$random_board_number;
        $info->category = "";
        $info->title = "게시판".$random_board_number;
        $info->base_rows = 10;
        $info->reg_date_yn = "N";
        $info->category_yn = "N";
        $info->file_cnt = "1";
        $info->file_upload_size_limit = "10";
        $info->file_upload_size_total = "100";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = array();

        return aview("csl/board/config/edit", $proc_result);
    }

    public function update()
    {
        $config_model = new BoardConfigModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $bc_idx = $this->request->getPost("bc_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $board_id = $this->request->getPost("board_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $category_yn = $this->request->getPost("category_yn", FILTER_SANITIZE_SPECIAL_CHARS);
        $category = $this->request->getPost("category", FILTER_SANITIZE_SPECIAL_CHARS);
        $base_rows = $this->request->getPost("base_rows", FILTER_SANITIZE_SPECIAL_CHARS);
        $reg_date_yn = $this->request->getPost("reg_date_yn", FILTER_SANITIZE_SPECIAL_CHARS);
        $file_cnt = $this->request->getPost("file_cnt", FILTER_SANITIZE_SPECIAL_CHARS);
        $file_upload_size_limit = $this->request->getPost("file_upload_size_limit", FILTER_SANITIZE_SPECIAL_CHARS);
        $file_upload_size_total = $this->request->getPost("file_upload_size_total", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["bc_idx"] = $bc_idx;
        $data["board_id"] = $board_id;
        $data["title"] = $title;
        $data["category_yn"] = $category_yn;
        $data["category"] = $category;
        $data["base_rows"] = $base_rows;
        $data["reg_date_yn"] = $reg_date_yn;
        $data["file_cnt"] = $file_cnt;
        $data["file_upload_size_limit"] = $file_upload_size_limit;
        $data["file_upload_size_total"] = $file_upload_size_total;

        $model_result = $config_model->checkConfigInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        if ($result == true) {
            if ($bc_idx == 0) {
                $model_result = $config_model->procConfigInsert($data);
                $bc_idx = $model_result["insert_id"];
            } else {
                $model_result = $config_model->procConfigUpdate($data);
            }
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/board/config/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $config_model = new BoardConfigModel();

        $bc_idx = $this->request->getUri()->getSegment(5, 0);

        $result = true;
        $message = "정상";

        $data = array();
        $data["bc_idx"] = $bc_idx;

        $model_result = $config_model->getConfigInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/board/config/view", $proc_result);
    }

    public function delete()
    {
        $config_model = new BoardConfigModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $bc_idx = $this->request->getUri()->getSegment(5, 0);

        $data = array();
        $data["bc_idx"] = $bc_idx;

        $model_result = $config_model->procConfigDelete($data);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/board/config/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $config_model = new BoardConfigModel();

        $result = true;
        $message = "정상";

        $bc_idx = $this->request->getUri()->getSegment(5, 0);

        $data = array();
        $data["bc_idx"] = $bc_idx;

        $model_result = $config_model->getConfigInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/board/config/edit", $proc_result);
    }

}
