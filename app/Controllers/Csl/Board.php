<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\BoardModel;
use App\Models\Csl\CommentModel;
use App\Models\Common\PagingModel;

class Board extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $board_model = new BoardModel();
        $paging_model = new PagingModel();

        $board_id = $this->request->getUri()->getSegment(3); // segments 확인
        $category = $this->request->getGet("category", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";

        // 검색창을 열어야 하는지 확인
        $search_open = $this->request->getGet("search_open", FILTER_SANITIZE_SPECIAL_CHARS) ?? "Y";
        if ($search_open == "Y") {
            $collapsed_card = "";
            $display_type = "block";
        } else {
            $collapsed_card = "collapsed-card";
            $display_type = "none";
        }

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";
        $search_arr["category"] = $category;
        $search_arr["search_open"] = $search_open;
        $search_arr["collapsed_card"] = $collapsed_card;
        $search_arr["display_type"] = $display_type;

        $data["search_arr"] = $search_arr;
        $data["board_id"] = $board_id;

        // 게시판 정보
        $model_result = $board_model->getConfigInfo($data);
        $config = $model_result["info"];

        $data["notice_yn"] = "N";
        $data["reg_date_yn"] = $config->reg_date_yn;
        $model_result = $board_model->getBoardList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        // 공지사항에는 분류 항목을 제외한다.
        $data["notice_yn"] = "Y";
        $search_arr["category"] = null;
        $data["search_arr"] = $search_arr;
        $model_result = $board_model->getBoardList($data);
        $notice_list = $model_result["list"];

        $data["cnt"] = $cnt;
        $paging_info = $paging_model->getPagingInfo($data);

        $search_arr["category"] = $category; // category 복구
        $data["search_arr"] = $search_arr;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["notice_list"] = $notice_list;
        $proc_result["paging_info"] = $paging_info;
        $proc_result["data"] = $data;
        $proc_result["config"] = $config;

        return aview("csl/board/detail/list", $proc_result);
    }

    public function write()
    {
        $board_model = new BoardModel();

        $result = true;
        $message = "정상";

        $board_id = $this->request->getUri()->getSegment(3, 0);

        $data = array();
        $data["board_id"] = $board_id;

        // 게시판 정보
        $model_result = $board_model->getConfigInfo($data);
        $config = $model_result["info"];
        $config->category_arr = explode("||", $config->category);

        $b_idx = 0;
        $title = "";
        $contents = "&nbsp;";
        $contents_code = "&nbsp;";
        $reg_date = date("Y-m-d H:i:s");
        $category = "";
        $notice_yn = "N";

        $info = (object)array();
        $info->b_idx = $b_idx;
        $info->title = $title;
        $info->reg_date = $reg_date;
        $info->contents = $contents;
        $info->contents_code = $contents_code;
        $info->category = $category;
        $info->notice_yn = $notice_yn;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["info"] = $info;
        $proc_result["config"] = $config;
        $proc_result["file_list"] = array();

        return aview("csl/board/detail/edit", $proc_result);
    }

    public function update()
    {
        $board_model = new BoardModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $board_id = $this->request->getPost("board_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $b_idx = $this->request->getPost("b_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $summer_code = (string)$this->request->getPost("summer_code");
        $summer_code = str_replace("<p><br></p><p>", "", $summer_code);
        $summer_code = str_replace("\r\n", "", $summer_code);
        $category = $this->request->getPost("category", FILTER_SANITIZE_SPECIAL_CHARS);
        $notice_yn = $this->request->getPost("notice_yn", FILTER_SANITIZE_SPECIAL_CHARS) ?? "N";
        $reg_date = $this->request->getPost("reg_date", FILTER_SANITIZE_SPECIAL_CHARS) ?? date("Y-m-d H:i:s");
        $file_list = $this->request->getPost("file_list") ?? array();

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;
        $data["contents"] = $summer_code;
        $data["title"] = $title;
        $data["file_list"] = $file_list;
        $data["category"] = $category;
        $data["notice_yn"] = $notice_yn;
        $data["reg_date"] = $reg_date;

        if ($result == true) {
            if ($b_idx == 0) {
                $model_result = $board_model->procBoardInsert($data);
                $b_idx = $model_result["insert_id"];
            } else {
                $model_result = $board_model->procBoardUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["return_url"] = "/csl/board/$board_id/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $board_model = new BoardModel();
        $comment_model = new CommentModel();

        $board_id = $this->request->getUri()->getSegment(3, 0);
        $b_idx = $this->request->getUri()->getSegment(5, 0);

        $result = true;
        $message = "정상";

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;

        // 게시판 정보 확인
        $model_result = $board_model->getConfigInfo($data);
        $config = $model_result["info"];

        $model_result = $board_model->getBoardInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];
        $data["info"] = $info;

        // 파일목록
        $model_result = $board_model->getBoardFileList($data);
        $file_list = $model_result["list"];

        // 댓글목록
        $model_result = $comment_model->getCommentList($data);
        $comment_list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;
        $proc_result["comment_list"] = $comment_list;
        $proc_result["config"] = $config;

        return aview("csl/board/detail/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $board_model = new BoardModel();

        $board_id = $this->request->getUri()->getSegment(3, 0);
        $b_idx = $this->request->getUri()->getSegment(5, 0);

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;

        $model_result = $board_model->procBoardDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["return_url"] = "/csl/board/$board_id/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $board_model = new BoardModel();

        $board_id = $this->request->getUri()->getSegment(3, 0);
        $b_idx = $this->request->getUri()->getSegment(5, 0);

        $result = true;
        $message = "정상";

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;

        $model_result = $board_model->getConfigInfo($data);
        $config = $model_result["info"];
        $config->category_arr = explode("||", $config->category);

        $model_result = $board_model->getBoardInfo($data);
        $info = $model_result["info"];
        $data["info"] = $info;

        // 파일목록
        $model_result = $board_model->getBoardFileList($data);
        $file_list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;
        $proc_result["config"] = $config;

        return aview("csl/board/detail/edit", $proc_result);
    }

}
