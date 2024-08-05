<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Common\UploadModel;

class Upload extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function general()
    {
        ini_set("memory_limit", "256M"); // 이미지의 압축을 풀었을때 등 최대 가능 용량(파일의 용량과는 다름)

        $upload_model = new UploadModel();

        $data = array();
        $data["input_file_id"] = (string)$this->request->getPost("file_id"); // 폼 마다 다른 업로드하는 파일 아이디
        $data["user_file"] = $this->request->getFile($data["input_file_id"]); // 올린 파일 정보 갖고 오기
        $data["quality"] = 80; // 이미지 저장시 퀄리티. jpeg기준 80이상 권장. 60이상을 입력해야한다.
        $data["resize_width"] = 2000; // 이미지일 경우 지정한 해상도보다 높은 경우 줄인다. 반드시 0 이상을 입력해야한다.
        $data["resize_height"] = 0; // 이미지 해상도를 0으로 지정한 경우 리사이징을 하지 않는다. width도 마찬가지
        $data["limit_size"] = 10; // 업로드 제한 사이즈 메가바이트 단위로 입력. 반드시 0 이상을 입력해야한다.

        $proc_result = $upload_model->uploadGeneralFile($data); // 파일을 올린다.

        return json_encode($proc_result);
    }

    public function board()
    {
        ini_set("memory_limit", "256M");

        $upload_model = new UploadModel();

        $data = array();
        $data["input_file_id"] = (string)$this->request->getPost("file_id"); // 폼 마다 다른 업로드하는 파일 아이디
        $data["user_file"] = $this->request->getFile($data["input_file_id"]); // 올린 파일 정보 갖고 오기
        $data["quality"] = 80; // 이미지 저장시 퀄리티. jpeg기준 80이상 권장. 60이상을 입력해야한다.
        $data["resize_width"] = 2000; // 이미지일 경우 지정한 해상도보다 높은 경우 줄인다. 반드시 0 이상을 입력해야한다.
        $data["resize_height"] = 0; // 이미지 해상도를 0으로 지정한 경우 리사이징을 하지 않는다. width도 마찬가지
        $data["limit_size"] = 10; // 업로드 제한 사이즈 메가바이트 단위로 입력. 반드시 0 이상을 입력해야한다.
        $data["board_id"] = $this->request->getPost("board_id"); // 게시판 아이디
        $data["file_list"] = $this->request->getPost("file_list"); // 기존에 업로드 되어 있던 파일 아이디들

        $proc_result = $upload_model->uploadBoardFile($data); // 파일을 올린다.

        return json_encode($proc_result);
    }

    // 원본파일 그대로
    public function original()
    {
        ini_set("memory_limit", "256M"); // 이미지의 압축을 풀었을때 등 최대 가능 용량(파일의 용량과는 다름)

        $upload_model = new UploadModel();

        $data = array();
        $data["input_file_id"] = (string)$this->request->getPost("file_id"); // 폼 마다 다른 업로드하는 파일 아이디
        $data["user_file"] = $this->request->getFile($data["input_file_id"]); // 올린 파일 정보 갖고 오기

        $proc_result = $upload_model->uploadOriginalFile($data); // 파일을 올린다.

        return json_encode($proc_result);
    }

    // 이미지 파일만 올릴수 있음.
    public function image()
    {
        ini_set("memory_limit", "256M"); // 이미지의 압축을 풀었을때 등 최대 가능 용량(파일의 용량과는 다름)

        $upload_model = new UploadModel();

        $data = array();
        $data["file_id"] = (string)$this->request->getPost("file_id"); // 폼 마다 다른 업로드하는 파일 아이디
        $data["user_file"] = $this->request->getFile($data["file_id"]); // 올린 파일 정보 갖고 오기
        $data["quality"] = 80; // 이미지 저장시 퀄리티. jpeg기준 80이상 권장. 60이상을 입력해야한다.
        $data["resize_width"] = 2000; // 이미지일 경우 지정한 해상도보다 높은 경우 줄인다. 반드시 0 이상을 입력해야한다.
        $data["resize_height"] = 0; // 이미지 해상도를 0으로 지정한 경우 리사이징을 하지 않는다. width도 마찬가지
        $data["limit_size"] = 10; // 업로드 제한 사이즈 메가바이트 단위로 입력. 반드시 0 이상을 입력해야한다.

        $proc_result = $upload_model->uploadImageFile($data); // 파일을 올린다.

        return json_encode($proc_result);
    }

}
