<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Csl\ContentsModel;

class Contents extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function view()
    {
        $contents_model = new ContentsModel();

        $c_idx = $this->request->getUri()->getSegment(3);

        $result = true;
        $message = "정상";

        $model_result = $contents_model->getContentsInfo($c_idx);
        $info = $model_result["info"];
        $title = $info->title;

        $title_info = (object)array();
        $title_info->title = $title;
        $title_info->head_title = " 페이지 &gt; ".$title;
        $title_info->bread_crumb = "홈 &gt; 페이지 &gt; ".$title;

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["title_info"] = $title_info;
        $proc_result["info"] = $info;

        return uview("/usr/contents/view", $proc_result);
    }

}
