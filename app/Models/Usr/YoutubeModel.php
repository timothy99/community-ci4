<?php

namespace App\Models\Usr;

use CodeIgniter\Model;

class YoutubeModel extends Model
{
    public function getPlaylistInfo($data)
    {
        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $y_idx = $data["y_idx"];

        $db = $this->db;
        $builder = $db->table("youtube");
        $builder->where("del_yn", "N");
        $builder->where("y_idx", $y_idx);
        $info = $builder->get()->getRow();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return $proc_result;
    }

    public function getVideoList($data)
    {
        $model_result = $this->getPlaylistInfo($data);
        $data = $model_result["info"];

        $result = true;
        $message = "성공";

        $max_result = 4;
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

}
