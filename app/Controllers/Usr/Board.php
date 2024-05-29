<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\BoardModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;
use App\Models\Csl\CommentModel;

class Board extends BaseController
{
    public function index()
    {
        return redirect()->to("/board/notice/list");
    }

    public function list()
    {
        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[1];

        $board_model = new BoardModel();
        $paging_model = new PagingModel();

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";
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
        $data["board_id"] = $board_id;

        $model_result = $board_model->getBoardList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/usr/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/board/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["board_id"] = $board_id;
        $proc_result["search_arr"] = $search_arr;

        return uview("usr/board/list", $proc_result);
    }

    public function view()
    {
        $board_model = new BoardModel();
        $file_model = new FileModel();
        $comment_model = new CommentModel();

        $board_id = $this->request->getUri()->getSegment(2);
        $b_idx = $this->request->getUri()->getSegment(4); // segments 확인

        $result = true;
        $message = "정상";

        $model_result = $board_model->getBoardInfo($b_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $file_arr = strlen($info->file_idxs) > 0 ? explode("|", $info->file_idxs) : array();
        $file_list = array();
        if (count($file_arr) > 0) {
            foreach($file_arr as $no => $val) {
                $file_info = $file_model->getFileInfo($val);
                $file_list[] = $file_info;
            }
        }

        // 댓글목록
        $model_result = $comment_model->getCommentList($b_idx);
        $comment_list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;
        $proc_result["comment_list"] = $comment_list;
        $proc_result["board_id"] = $board_id;

        return uview("usr/board/view", $proc_result);
    }

    public function write()
    {
        $board_id = $this->request->getUri()->getSegment(2); // segments 확인

        $result = true;
        $message = "정상";

        $b_idx = 0;
        $title = "";
        $contents = "&nbsp;";
        $contents_code = "&nbsp;";

        $info = (object)array();
        $info->b_idx = $b_idx;
        $info->title = $title;
        $info->contents = $contents;
        $info->contents_code = $contents_code;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = array();

        return uview("usr/board/edit", $proc_result);
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
        $file_model = new FileModel();

        $board_id = $this->request->getUri()->getSegment(2);
        $b_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $board_model->getBoardInfo($b_idx);
        $info = $model_result["info"];
        $file_arr = strlen($info->file_idxs) > 0 ? explode("|", $info->file_idxs) : array();
        $file_list = array();
        if (count($file_arr) > 0) {
            foreach($file_arr as $no => $val) {
                $file_info = $file_model->getFileInfo($val);
                $file_list[] = $file_info;
            }
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["board_id"] = $board_id;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;

        return uview("usr/board/edit", $proc_result);
    }

}
