<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\BoardModel;
use App\Models\Common\PagingModel;

use App\Models\Csl\CommentModel;
use App\Models\Usr\BoardConfigModel;

class Board extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function list()
    {
        $board_model = new BoardModel();
        $paging_model = new PagingModel();
        $config_model = new BoardConfigModel();

        $board_id = $this->request->getUri()->getSegment(2); // segments 확인

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

        $data["search_arr"] = $search_arr;
        $data["board_id"] = $board_id;

        $model_result = $board_model->getBoardList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        $data["cnt"] = $cnt;
        $paging_info = $paging_model->getPagingInfo($data);

        $model_result = $config_model->getConfigInfo($data);
        $config_info = $model_result["info"];
        $title = $config_info->title;

        $title_info = (object)array();
        $title_info->title = $title;
        $title_info->head_title = " 게시판 &gt; ".$title."  &gt; 목록";
        $title_info->bread_crumb = "홈 &gt; 게시판 &gt; ".$title."  &gt; 목록";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["title_info"] = $title_info;
        $proc_result["config_info"] = $config_info;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging_info"] = $paging_info;
        $proc_result["data"] = $data;
        $proc_result["board_id"] = $board_id;

        return uview("usr/board/skin/".$config_info->type."/list", $proc_result);
    }

    public function view()
    {
        $board_model = new BoardModel();

        $comment_model = new CommentModel();
        $config_model = new BoardConfigModel();

        $board_id = $this->request->getUri()->getSegment(2);
        $b_idx = $this->request->getUri()->getSegment(4); // segments 확인

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;

        $result = true;
        $message = "정상";

        $model_result = $board_model->getBoardInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        // 댓글목록
        $model_result = $comment_model->getCommentList($data);
        $comment_list = $model_result["list"];

        $model_result = $config_model->getConfigInfo($data);
        $config_info = $model_result["info"];
        $title = $config_info->title;

        $title_info = (object)array();
        $title_info->title = $title;
        $title_info->head_title = " 게시판 &gt; ".$title."  &gt; ".$info->title."  &gt; 보기";
        $title_info->bread_crumb = "홈 &gt; 게시판 &gt; ".$title."  &gt; 보기";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["title_info"] = $title_info;
        $proc_result["info"] = $info;
        $proc_result["comment_list"] = $comment_list;
        $proc_result["board_id"] = $board_id;

        return uview("usr/board/skin/".$config_info->type."/view", $proc_result);
    }

    public function write()
    {
        $config_model = new BoardConfigModel();

        $board_id = $this->request->getUri()->getSegment(2); // segments 확인

        $result = true;
        $message = "정상";

        $b_idx = 0;
        $title = "";
        $contents = "";
        $contents_code = "";

        $info = (object)array();
        $info->b_idx = $b_idx;
        $info->title = $title;
        $info->contents = $contents;
        $info->contents_code = $contents_code;
        $info->file_list = array();

        $data["board_id"] = $board_id;

        $model_result = $config_model->getConfigInfo($data);
        $config_info = $model_result["info"];
        $title = $config_info->title;

        $title_info = (object)array();
        $title_info->title = $title;
        $title_info->head_title = " 게시판 &gt; ".$title."  &gt; 쓰기";
        $title_info->bread_crumb = "홈 &gt; 게시판 &gt; ".$title."  &gt; 쓰기";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["title_info"] = $title_info;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["info"] = $info;

        return uview("usr/board/skin/".$config_info->type."/edit", $proc_result);
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

        $file_list = $this->request->getPost("file_list") ?? array();
        if (count($file_list) > 0) {
            $file_idxs = implode("|", $file_list);
        } else {
            $file_idxs = null;
        }

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;
        $data["contents"] = $summer_code;
        $data["title"] = $title;
        $data["file_idxs"] = $file_idxs;

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
        $proc_result["return_url"] = "/board/$board_id/list";

        return json_encode($proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $board_model = new BoardModel();

        $board_id = $this->request->getUri()->getSegment(2);
        $b_idx = $this->request->getUri()->getSegment(4);

        $model_result = $board_model->procBoardDelete($b_idx);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["return_url"] = "/board/$board_id/list";

        return json_encode($proc_result);
    }

    public function edit()
    {
        $board_model = new BoardModel();
        $config_model = new BoardConfigModel();

        $board_id = $this->request->getUri()->getSegment(2);
        $b_idx = $this->request->getUri()->getSegment(4);

        $data = array();
        $data["board_id"] = $board_id;
        $data["b_idx"] = $b_idx;

        $result = true;
        $message = "정상";

        $model_result = $board_model->getBoardInfo($data);
        $info = $model_result["info"];
        $data["info"] = $info;

        $model_result = $config_model->getConfigInfo($data);
        $config_info = $model_result["info"];
        $config_info->category_arr = explode("||", $config_info->category);
        $title = $config_info->title;

        $title_info = (object)array();
        $title_info->title = $title;
        $title_info->head_title = " 게시판 &gt; ".$title."  &gt; ".$info->title."  &gt; 수정";
        $title_info->bread_crumb = "홈 &gt; 게시판 &gt; ".$title."  &gt; 수정";

        // 파일목록
        $model_result = $board_model->getBoardFileList($data);
        $file_list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["title_info"] = $title_info;
        $proc_result["config_info"] = $config_info;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;

        return uview("usr/board/skin/".$config_info->type."/edit", $proc_result);
    }

}
