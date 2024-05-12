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
        $file_model = new FileModel();

        $result = true;
        $message = "파일 업로드를 시작합니다.";
        $file_id = 0;
        $input_file_id = (string)$this->request->getPost("file_id");

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["file_id"] = $file_id;
        $proc_result["input_file_id"] = $input_file_id;

        $user_file = $this->request->getFile($input_file_id); // 올린 파일 정보 갖고 오기
        if ($user_file == null) {
            $result = false;
            $proc_result["result"] = false;
            $proc_result["message"] = "업로드가 실패하였습니다.";
        }

        if ($result == true) {
            $is_valid = $user_file->isValid(); // 파일이 정상인지 확인
            if($is_valid == false) { // 올린 파일이 잘못된 경우
                throw new \RuntimeException($user_file->getErrorString()."(".$user_file->getError().")"); // 에러를 던진다
            } else { // 파일이 정상인 경우
                $validation_rule = ["file"=>["label"=>"Image File", "rules"=>"uploaded[".$input_file_id."]|is_image[".$input_file_id."]"]]; // 이미지인지 검증
                $validation_result = $this->validate($validation_rule);
                if ($validation_result == false) { // 이미지가 아닌 경우
                    $proc_result = $file_model->uploadFile($user_file); // 파일을 올린다.
                    $file_id = $proc_result["file_id"];
                    $file_name_org = $proc_result["file_name_org"];
                    $proc_result["file_path"] = "/csl/file/download/".$file_id;
                    $proc_result["file_html"] = "<a href=\"/csl/file/download/".$file_id."\">".$file_name_org."</a>";
                    $proc_result["down_html"] = $proc_result["file_html"];
                } else { // 이미지 파일인 경우
                    $proc_result = $file_model->uploadImage($user_file); // 파일을 올린다.
                    $file_id = $proc_result["file_id"];
                    $file_name_org = $proc_result["file_name_org"];
                    $html_image_width = $proc_result["html_image_width"];
                    $proc_result["file_path"] = "/csl/file/view/".$file_id;
                    $proc_result["file_html"] = "<img src=\"/csl/file/view/".$file_id."\" style=\"width:".$html_image_width."px\">"; // 이미지 파일인 경우 img 태그를 제공
                    $proc_result["down_html"] = "<a href=\"/csl/file/download/".$file_id."\">".$file_name_org."</a>";
                }
            }
        }
        $proc_result["input_file_id"] = $input_file_id;

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
