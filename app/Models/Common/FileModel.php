<?php

namespace App\Models\Common;

use CodeIgniter\Model;
use App\Models\Common\SecurityModel;
use stdClass;
use Throwable;

class FileModel extends Model
{
    // 확장자 체크 해서 필터에 따라 분류가 맞는지 확인
    public function checkMimeType($user_file_type, $check_type)
    {
        $mime_type = array();
        // 이미지용 mime_type 처리
        if ($check_type == "image") {
            $mime_type[] = "image/png";
            $mime_type[] = "image/jpg";
            $mime_type[] = "image/jpeg";
            $mime_type[] = "image/gif";
        } else {
            $mime_type[] = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; // 엑셀(xlsx)
            $mime_type[] = "application/vnd.ms-excel"; // 엑셀(xls)
            $mime_type[] = "application/vnd.openxmlformats-officedocument.presentationml.presentation"; // 파워포인트(pptx)
            $mime_type[] = "application/vnd.ms-powerpoint"; // 파워포인트(ppt)
            $mime_type[] = "application/vnd.openxmlformats-officedocument.wordprocessingml.document"; // 워드(docx)
            $mime_type[] = "application/msword"; // 워드(doc)
            $mime_type[] = "text/plain"; // 텍스트
            $mime_type[] = "application/pdf"; // PDF
            $mime_type[] = "application/zip"; // ZIP
            $mime_type[] = "application/x-hwp"; // 한글파일
            $mime_type[] = "image/png";
            $mime_type[] = "image/jpg";
            $mime_type[] = "image/jpeg";
            $mime_type[] = "image/gif";
        }
        $check_mime_type = in_array($user_file_type, $mime_type);

        return $check_mime_type;
    }

    // 파일 사이즈 체크해서 우리가 설정한 크기와 맞는지 확인
    public function checkFileSize($upload_size, $limit_size)
    {
        $limit_size = $limit_size*1024*1024; // MB단위로 입력된 숫자를 바이트 단위로 변경
        // 입력받은 이미지 사이즈와 비교해서
        if ($upload_size > $limit_size) { // 이미지 사이즈가 크면
            $check_file_size = false; // false 반환
        } else { // 이미지 사이즈가 규정보다 작으면
            $check_file_size = true; // true 반환
        }

        return $check_file_size;
    }

    // 파일을 저장한다.
    public function saveFile($user_file)
    {
        $security_model = new SecurityModel();

        $upload_date_path = date("Y/m"); // 업로드 디렉토리는 연/월로 생성
        $random_name = $user_file->getRandomName(); // 랜덤네임 생성
        $user_file->store($upload_date_path, $random_name); // 저장
        $file_id = $security_model->getRandomString(4, 32); // 보안을 위한 랜덤문자 생성

        $file_info = array();
        $file_info["file_name_org"] = $user_file->getClientName();
        $file_info["file_directory"] = $upload_date_path;
        $file_info["file_name_uploaded"] = $random_name;
        $file_info["file_id"] = $file_id;
        $file_info["file_path"] = $file_id;

        return $file_info;
    }

    // 파일 정보 DB에 저장
    public function insertFileInfo($data)
    {
        $file_name_org = $data["file_name_org"];
        $file_directory = $data["file_directory"];
        $file_name_uploaded = $data["file_name_uploaded"];
        $file_size = $data["file_size"];
        $file_ext = $data["file_ext"];
        $image_width = $data["image_width"];
        $image_height = $data["image_height"];
        $mime_type = $data["mime_type"];
        $category = $data["category"];
        $file_id = $data["file_id"];

        $member_id = getUserSessionInfo("member_id"); // 세션의 정보중 아이디를 갖고 옵니다.

        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $db = $this->db;
        $db->transStart();
        $builder = $db->table("file");
        $builder->set("file_id", $file_id);
        $builder->set("file_name_org", $file_name_org);
        $builder->set("file_directory", $file_directory);
        $builder->set("file_name_uploaded", $file_name_uploaded);
        $builder->set("file_size", $file_size);
        $builder->set("file_ext", $file_ext);
        $builder->set("image_width", $image_width);
        $builder->set("image_height", $image_height);
        $builder->set("mime_type", $mime_type);
        $builder->set("category", $category);
        $builder->set("del_yn", "N");
        $builder->set("ins_id", $member_id);
        $builder->set("ins_date", $today);
        $builder->set("upd_id", $member_id);
        $builder->set("upd_date", $today);
        $result = $builder->insert();

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
        $model_result["file_id"] = $file_id;
        $model_result["file_name_org"] = $file_name_org;

        return $model_result;
    }

    // 이미지 파일 리사이즈
    public function resizeImageFile($data)
    {

        $file_path = $data["file_path"];
        $mime_type = $data["mime_type"];
        $width = $data["resize_width"];
        $height = $data["resize_height"];
        $quality = $data["quality"];

        $image_path = UPLOADPATH.$file_path;
        $image = \Config\Services::image();
        $image->withFile($image_path); // 어느 이미지 수정할지 결정
        if ($mime_type == "image/png") {
            $image->convert(IMAGETYPE_PNG); // png일 경우 투명이미지가 있을수 있으니 따로 리사이징해 저장
        } else {
            $image->convert(IMAGETYPE_JPEG); // 그 외 이미지는 모두 jpg로 가공한다.
        }

        // 이미지의 가로세로 해상도를 구해서 0보다 크지만 지정된 이미지 크기보다 큰 경우 최대 해상도로 고정
        $image_width = $image->getWidth();
        if($image_width < $width) {
            $width = $image_width;
        }
        $image_height = $image->getHeight();
        if($image_height < $height) {
            $height = $image_height;
        }

        if($width == 0 && $height == 0) {
            // 이미지 처리를 하지 않는다
        } else {
            $master_dimension = "auto";
            // 이미지 크기를 0으로 지정할 경우 비율에 맞추는 이미지로 설정
            if ($width == 0) {
                $master_dimension = "height";
            } elseif ($height == 0) {
                $master_dimension = "width";
            }
            $image->resize($width, $height, true, $master_dimension);
        }
        $image->save($image_path, $quality); // 이미지를 저장할때 퀄리티 조정은 반드시 한다. CI프레임워크의 기본값은 90
        $image_width = $image->getWidth();
        $image_height = $image->getHeight();

        // 파일에 대한 저장 용량 얻기
        $file = new \CodeIgniter\Files\File($image_path);
        $file_size = $file->getSize();

        $proc_result = array();
        $proc_result["file_size"] = $file_size;
        $proc_result["image_width"] = $image_width;
        $proc_result["image_height"] = $image_height;

        return $proc_result;
    }

    public function getFileInfo($file_id)
    {
        $file_id = (string)$file_id;
        $db = $this->db;
        $builder = $db->table("file");
        $builder->where("file_id", $file_id);
        $builder->where("del_yn", "N");
        $db_info = $builder->get()->getFirstRow(); // 쿼리 실행
        $db_info->file_path = UPLOADPATH.$db_info->file_directory."/".$db_info->file_name_uploaded;

        if($db_info == null) {
            $db_info = new stdClass;
            $db_info->download_html = null;
            $db_info->file_directory = null;
            $db_info->file_name_uploaded = null;
            $db_info->file_name_org = null;
        } else {
            $file_id = $db_info->file_id;
            $file_name_org = $db_info->file_name_org;
            $db_info->file_name_org = $file_name_org;
        }

        return $db_info;
    }

    // 서버에 저장된 파일의 경로 생성
    public function getFilePath($file_directory, $file_name_uploaded)
    {
        $file_path = UPLOADPATH.$file_directory."/".$file_name_uploaded;

        return $file_path;
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

    public function uploadFile($data)
    {
        $result = true;
        $message = "파일업로드 시작";
        $file_id = 0;
        $limit_size = $data["limit_size"];
        $user_file = $data["user_file"];
        $category = $data["category"];

        $data["mime_type"] = $user_file->getMimeType(); // mimetype이 정상인지 확인한다
        $data["file_ext"] = $user_file->getClientExtension(); // 파일 확장자

        // 허용된 이미지 크기를 넘지 않는지 확인한다.
        $upload_size = $user_file->getSize();
        $check_file_size = $this->checkFileSize($upload_size, $limit_size);
        if($check_file_size == false) {
            $result = false;
            $message = "파일이 ".$limit_size."MB 보다 큽니다";
        }

        $data["upload_size"] = $upload_size;
        $data["file_size"] = $upload_size;
        if($result == false) {
            $file_name_org = "error";
        } else {
            $file_info = $this->saveFile($user_file); // 파일을 저장하고 저장된 경로를 반환한다.
            $data["file_name_org"] = $file_info["file_name_org"];
            $data["file_directory"] = $file_info["file_directory"];
            $data["file_name_uploaded"] = $file_info["file_name_uploaded"];
            $data["file_id"] = $file_info["file_id"];
            $file_path = $file_info["file_directory"]."/".$file_info["file_name_uploaded"];
            $data["file_path"] = $file_path;
            

            // 이미지인 경우 리사이징 처리
            if ($category == "image") {
                $model_result = $this->resizeImageFile($data);
                $data["file_size"] = $model_result["file_size"];
                $data["image_width"] = $model_result["image_width"];
                $data["image_height"] = $model_result["image_height"];
            } else {
                $data["image_width"] = 0;
                $data["image_height"] = 0;
            }

            $model_result = $this->insertFileInfo($data); // DB에 파일 정보 저장

            $result = $model_result["result"];
            $message = $model_result["message"];
            $file_id = $model_result["file_id"];
            $file_name_org = $model_result["file_name_org"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["file_id"] = $file_id;
        $proc_result["file_name_org"] = $file_name_org;
        $proc_result["input_file_id"] = $data["input_file_id"];

        return $proc_result;
    }

}
