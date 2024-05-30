<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Common\FileModel;

class File extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function upload()
    {
        ini_set("memory_limit", "256M");

        $file_model = new FileModel();

        $result = true;
        $message = "파일 업로드를 시작합니다.";
        $input_file_id = (string)$this->request->getPost("file_id");
        $quality = 80; // 이미지 저장시 퀄리티 quality를 지정하지 않아도 80으로 되어 있다.
        $limit_size = 10; // 0메가 바이트 업로드 제한 사이즈 메가바이트 단위로 입력
        $resize_width = 2000; // 이미지일 경우 지정한 해상도보다 높은 경우 줄인다.
        $resize_height = 0; // 이미지 해상도를 0으로 지정한 경우 리사이징을 하지 않는다. width도 마찬가지

        $user_file = $this->request->getFile($input_file_id); // 올린 파일 정보 갖고 오기
        if ($user_file == null) {
            $result = false;
            $proc_result["result"] = false;
            $proc_result["message"] = "업로드가 실패하였습니다.";
        }

        $data = array();
        $data["result"] = $result;
        $data["message"] = $message;
        $data["input_file_id"] = $input_file_id;
        $data["quality"] = $quality;
        $data["user_file"] = $user_file;
        $data["limit_size"] = $limit_size;
        $data["resize_width"] = $resize_width;
        $data["resize_height"] = $resize_height;

        if ($result == true) {
            $is_valid = $user_file->isValid(); // 파일이 정상인지 확인
            if($is_valid == false) { // 올린 파일이 잘못된 경우
                throw new \RuntimeException($user_file->getErrorString()."(".$user_file->getError().")"); // 에러를 던진다
            } else { // 파일이 정상인 경우
                $validation_rule = ["file"=>["label"=>"Image File", "rules"=>"uploaded[".$input_file_id."]|is_image[".$input_file_id."]"]]; // 이미지인지 검증
                $validation_result = $this->validate($validation_rule);
                $data["category"] = $validation_result === true ? "image" : "file";
                $proc_result = $file_model->uploadFile($data); // 파일을 올린다.
            }
        }
        $proc_result["category"] = $data["category"]; // 서머노트 html 생성 때문에 카테고리를 반환해준다.

        return json_encode($proc_result);
    }

    // 파일 보기 모드
    public function view()
    {
        $file_model = new FileModel();

        $file_id = $this->request->getUri()->getSegment(4);

        $file_info = $file_model->getFileInfo($file_id); // 파일소유권 확인 및 파일 정보 확인
        $file_path = $file_model->getFilePath($file_info->file_directory, $file_info->file_name_uploaded); // 파일 업로드 경로 확보
        $raw_file = $file_model->getRawFile($this->response, $file_path); // 파일 다운로드

        return $raw_file;
    }

    // 파일 다운로드 모드. 이지미임에도 불구하고 다운로드가 필요한 경우가 있음.
    public function download()
    {
        $file_model = new FileModel();

        $file_id = $this->request->getUri()->getSegment(4);

        $file_info = $file_model->getFileInfo($file_id); // 파일소유권 확인 및 파일 정보 확인
        $file_path = $file_model->getFilePath($file_info->file_directory, $file_info->file_name_uploaded); // 파일 업로드 경로 확보
        $file_download = $this->response->download($file_path, null)->setFileName($file_info->file_name_org); // 파일 다운로드

        return $file_download;
    }

}
