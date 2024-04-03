<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\DateModel;
use App\Models\Csl\BoardModel;
use App\Models\Csl\CommentModel;
use App\Models\Common\PagingModel;
use App\Models\Common\FileModel;

class Board extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/board/notice/list");
    }

    public function list()
    {
        $board_model = new BoardModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $board_id = $this->request->getUri()->getSegment(3); // segments 확인

        $rows = 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";

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

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

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
        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[2];

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

        return aview("csl/board/edit", $proc_result);
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
        $proc_result["return_url"] = "/csl/board/$board_id/list";

        return json_encode($proc_result);
    }

    public function view()
    {
        $board_model = new BoardModel();
        $date_model = new DateModel();
        $file_model = new FileModel();
        $comment_model = new CommentModel();

        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[2];
        $b_idx = $segments[4];

        $result = true;
        $message = "정상";

        $model_result = $board_model->getBoardInfo($b_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);

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
        $proc_result["board_id"] = $board_id;
        $proc_result["info"] = $info;
        $proc_result["file_list"] = $file_list;
        $proc_result["comment_list"] = $comment_list;

        return aview("csl/board/view", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $board_model = new BoardModel();

        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $b_idx = $segments[4];
        $board_id = $segments[2];

        $model_result = $board_model->procBoardDelete($b_idx);

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
        $file_model = new FileModel();

        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[2];
        $b_idx = $segments[4];

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

        return aview("csl/board/edit", $proc_result);
    }

}
