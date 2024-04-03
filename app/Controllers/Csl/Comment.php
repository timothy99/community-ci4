<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\CommentModel;

class Comment extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/board/notice/list");
    }

    public function insert()
    {
        $comment_model = new CommentModel();

        $result = true;
        $message = "정상처리";

        $b_idx = $this->request->getPost("b_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $comment = $this->request->getPost("comment", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["b_idx"] = $b_idx;
        $data["comment"] = $comment;
        $model_result = $comment_model->procCommentInsert($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["b_idx"] = $b_idx;
        $proc_result["return_url"] = getUserSessionInfo("previous_url");

        echo json_encode($proc_result);
    }

    public function delete()
    {
        $comment_model = new CommentModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $bc_idx = $this->request->getUri()->getSegment(4);

        $model_result = $comment_model->procCommentDelete($bc_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = getUserSessionInfo("previous_url");

        return json_encode($proc_result);
    }

    public function edit()
    {
        $comment_model = new CommentModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $bc_idx = $this->request->getUri()->getSegment(4);

        $model_result = $comment_model->getCommentInfo($bc_idx);
        $info = $model_result["info"];
        $result = $model_result["result"];
        $message = $model_result["message"];

        $comment_edit_html = view("csl/comment/edit", $model_result);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_html"] = $comment_edit_html;

        return json_encode($proc_result);
    }

    public function update()
    {
        $comment_model = new CommentModel();

        $result = true;
        $message = "정상처리";

        $bc_idx = $this->request->getPost("bc_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $comment = $this->request->getPost("comment", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["bc_idx"] = $bc_idx;
        $data["comment"] = $comment;

        $model_result = $comment_model->procCommentUpdate($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["b_idx"] = $bc_idx;
        $proc_result["return_url"] = getUserSessionInfo("previous_url");

        echo json_encode($proc_result);
    }

}
