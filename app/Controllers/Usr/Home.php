<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Csl\SlideModel;
use App\Models\Usr\BoardModel;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to("/home/home");
    }

    public function home()
    {
        $board_model = new BoardModel();
        $slide_model = new SlideModel();

        $result = true;
        $message = "정상처리";

        $data = array();
        $data["rows"] = 3;
        $data["page"] = 1;
        $data["board_id"] = "notice";
        $data["search_arr"]["search_condition"] = null;
        $data["search_arr"]["search_text"] = null;

        $model_result = $board_model->getBoardList($data);
        $notice_list = $model_result["list"];

        $data["board_id"] = "free";
        $model_result = $board_model->getBoardList($data);
        $free_list = $model_result["list"];

        $model_result = $slide_model->getSlideList($data);
        $slide_list = $model_result["list"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["notice_list"] = $notice_list;
        $proc_result["free_list"] = $free_list;
        $proc_result["slide_list"] = $slide_list;

        return uview("usr/home/home", $proc_result);
    }

}
