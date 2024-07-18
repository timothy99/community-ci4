<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\AskModel;
use App\Models\Usr\MailModel;

class Ask extends BaseController
{
    public function write()
    {
        $ask_model = new AskModel();
        $mail_model = new MailModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $name = $this->request->getPost("name", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = $this->request->getPost("phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $agree_yn = $this->request->getPost("agree_yn", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($name == null) {
            $result = false;
            $message = "성함을 입력해주세요.";
        }

        if ($phone == null) {
            $result = false;
            $message = "전화번호를 입력해주세요.";
        }

        if ($agree_yn == null) {
            $result = false;
            $message = "개인정보처리취급방침을 읽고 동의해주세요.";
        }

        $data = array();
        $data["name"] = $name;
        $data["phone"] = $phone;
        if ($result == true) {
            $model_result = $ask_model->procAskInsert($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        // 입력이 끝나면 메일 보내기
        if ($result == true) {
            $data = array();
            $data["receive_email"] = env("app.managerEmail");
            $data["title"] = $name."님의 간편문의가 등록되었습니다.";
            $data["contents"] = "성함 : ".$name."<br>연락처 : ".$phone;
            $model_result = $mail_model->procMailSend($data);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/";

        return json_encode($proc_result);
    }

}
