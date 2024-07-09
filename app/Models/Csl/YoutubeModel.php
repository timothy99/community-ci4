<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;

class YoutubeModel extends Model
{
    public function getPlayList($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        $db = $this->db;
        $builder = $db->table("youtube");
        $builder->where("del_yn", "N");
        if ($search_text != null) {
            $builder->like($search_condition, $search_text);
        }
        $builder->orderBy("y_idx", "desc");
        $builder->limit($rows, getOffset($page, $rows));
        $cnt = $builder->countAllResults(false);
        $list = $builder->get()->getResult();
        foreach ($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    public function getPlaylistInfo($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $y_idx = $data["y_idx"];

        $db = $this->db;
        $builder = $db->table("youtube");
        $builder->where("del_yn", "N");
        $builder->where("y_idx", $y_idx);
        $info = $builder->get()->getRow();

        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function getVideoList($data)
    {
        $result = true;
        $message = "성공";

        $max_result = 5;
        $order = "date";
        $part = "snippet";
        $category = $data->category;
        $play_id = $data->play_id;
        $key = env("youtube.api.key");

        if ($category == "channel") {
            $url = "https://www.googleapis.com/youtube/v3/search?order=".$order."&part=".$part."&channelId=".$play_id."&maxResults=".$max_result."&key=".$key;
        } else {
            $url = "https://www.googleapis.com/youtube/v3/playlistItems?order=".$order."&part=".$part."&playlistId=".$play_id."&maxResults=".$max_result."&key=".$key;
        }

        $data = array();
        $data["url"] = $url;

        $helper_result = getCurlGet($data);

        $result = $helper_result["result"];
        $message = $helper_result["message"];
        $json_list = json_decode($helper_result["response"]);

        $result = isset($json_list->error->code) ? false : true;
        $message = "설정이 올바르지 않습니다.";

        $list = array();
        if ($result == true) {
            foreach($json_list->items as $no => $val) {
                if ($category == "channel") {
                    $video_id = $val->id->videoId;
                    $publish_time = $val->snippet->publishTime;
                } else {
                    $video_id = $val->snippet->resourceId->videoId;
                    $publish_time = $val->snippet->publishedAt;
                }

                $title = $val->snippet->title;
                $description = $val->snippet->description;
                $thumbnail_default = $val->snippet->thumbnails->default->url;
                $thumbnail_medium = $val->snippet->thumbnails->medium->url;
                $thumbnail_high = $val->snippet->thumbnails->high->url;
                $channel_title = $val->snippet->channelTitle;

                $info = (object)array();
                $info->video_id = $video_id;
                $info->title = $title;
                $info->description = $description;
                $info->thumbnail_default = $thumbnail_default;
                $info->thumbnail_medium = $thumbnail_medium;
                $info->thumbnail_high = $thumbnail_high;
                $info->channel_title = $channel_title;
                $info->publish_time = $publish_time;
                $list[]  = $info;
            }
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

    // 게시판 입력
    public function procPlaylistInsert($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $title = $data["title"];
        $category = $data["category"];
        $play_id = $data["play_id"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("youtube");
        $builder->set("title", $title);
        $builder->set("category", $category);
        $builder->set("play_id", $play_id);
        $builder->set("del_yn", "N");
        $builder->set("ins_id", $user_id);
        $builder->set("ins_date", $today);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $result = $builder->insert();
        $insert_id = $db->insertID();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;
        $model_result["insert_id"] = $insert_id;

        return $model_result;
    }

    // 게시판 입력
    public function procPlaylistUpdate($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $user_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $y_idx = $data["y_idx"];
        $title = $data["title"];
        $category = $data["category"];
        $play_id = $data["play_id"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("youtube");
        $builder->set("title", $title);
        $builder->set("category", $category);
        $builder->set("play_id", $play_id);
        $builder->set("upd_id", $user_id);
        $builder->set("upd_date", $today);
        $builder->where("y_idx", $y_idx);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    // 게시판 삭제
    public function procPlaylistDelete($data)
    {
        // 게시판 입력과 관련된 기본 정보
        $member_id = getUserSessionInfo("member_id");
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $y_idx = $data["y_idx"];

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("youtube");
        $builder->set("del_yn", "Y");
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $builder->where("y_idx", $y_idx);
        $result = $builder->update();

        if ($db->transStatus() === false) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.";
            $db->transRollback();
        } else {
            $db->transCommit();
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

    public function getSearchList($data)
    {
        $search_text = $data["search_text"];

        $key = env("youtube.api.key");

        $url = "https://www.googleapis.com/youtube/v3/search?key=".$key."&part=snippet&q=".$search_text."&maxResults=10";

        $data = array();
        $data["url"] = $url;

        $helper_result = getCurlGet($data);

        $result = $helper_result["result"];
        $message = $helper_result["message"];
        $json_list = json_decode($helper_result["response"]);

        $list = array();
        foreach($json_list->items as $no => $val) {
            if ($val->id->kind == "youtube#video") {
                $video_id = $val->id->videoId;
                $title = $val->snippet->title;
                $description = $val->snippet->description;
                $thumbnail_default = $val->snippet->thumbnails->default->url;
                $thumbnail_medium = $val->snippet->thumbnails->medium->url;
                $thumbnail_high = $val->snippet->thumbnails->high->url;
                $channel_title = $val->snippet->channelTitle;
                $channel_id = $val->snippet->channelId;
                $publish_time = $val->snippet->publishTime;

                $info = (object)array();
                $info->video_id = $video_id;
                $info->title = $title;
                $info->description = $description;
                $info->thumbnail_default = $thumbnail_default;
                $info->thumbnail_medium = $thumbnail_medium;
                $info->thumbnail_high = $thumbnail_high;
                $info->channel_title = $channel_title;
                $info->channel_id = $channel_id;
                $info->publish_time = $publish_time;
                $list[]  = $info;
            }
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;

        return $proc_result;
    }

}
