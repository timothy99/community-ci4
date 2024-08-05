<?php

namespace App\Models\Common;

use CodeIgniter\Model;
use stdClass;
use Throwable;

class DownloadModel extends Model
{
    public function getFileInfo($file_id)
    {
        $file_id = (string)$file_id;
        $db = $this->db;
        $builder = $db->table("file");
        $builder->where("file_id", $file_id);
        $builder->where("del_yn", "N");
        $db_info = $builder->get()->getFirstRow(); // 쿼리 실행

        if($db_info == null) {
            $db_info = new stdClass;
            $db_info->download_html = null;
            $db_info->file_directory = null;
            $db_info->file_name_uploaded = null;
            $db_info->file_name_org = null;
        } else {
            $db_info->file_path = UPLOADPATH.$db_info->file_directory."/".$db_info->file_name_uploaded;
            $file_id = $db_info->file_id;
            $file_name_org = $db_info->file_name_org;
            $db_info->file_name_org = $file_name_org;
        }

        return $db_info;
    }

    public function getRawFile($response, $file_path)
    {
        try {
            $raw_file = $response->download($file_path, null); // 파일 다운로드
        } catch (Throwable $t) {
            $raw_file = $response->download("resource/community/image/no_image.png", null); // 기본 이미지로 다운로드
        }

        return $raw_file;
    }

}
