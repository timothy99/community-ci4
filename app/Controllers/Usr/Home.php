<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\SlideModel;
use App\Models\Usr\BoardModel;
use App\Models\Usr\PopupModel;
use App\Models\Usr\YoutubeModel;

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
        $popup_model = new PopupModel();
        $youtube_model = new YoutubeModel();

        $result = true;
        $message = "정상처리";

        $data = array();
        $data["search_arr"]["rows"] = 3;
        $data["page"] = 1;
        $data["board_id"] = "board6967";
        $data["search_arr"]["search_condition"] = null;
        $data["search_arr"]["search_text"] = null;

        $model_result = $board_model->getBoardList($data);
        $notice_list = $model_result["list"];

        $data["board_id"] = "board597";
        $model_result = $board_model->getBoardList($data);
        $free_list = $model_result["list"];

        $model_result = $slide_model->getSlideList($data);
        $slide_list = $model_result["list"];

        $model_result = $popup_model->getPopupList($data);
        $popup_list = $model_result["list"];

        $data["y_idx"] = 1; // 유튜브 설정목록에 넣어둔 인덱스. 지금은 고정값으로 처리
        $model_result = $youtube_model->getVideoList($data);
        $video_list = $model_result["list"];

        $title_info = (object)array();
        $title_info->title = "대시보드";
        $title_info->head_title = "홈 &gt; 대시보드";
        $title_info->bread_crumb = "홈 &gt; 대시보드";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["title_info"] = $title_info;
        $proc_result["notice_list"] = $notice_list;
        $proc_result["free_list"] = $free_list;
        $proc_result["slide_list"] = $slide_list;
        $proc_result["popup_list"] = $popup_list;
        $proc_result["video_list"] = $video_list;

        return uview("usr/home/home", $proc_result);
    }

}
