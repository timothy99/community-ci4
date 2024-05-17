<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\MailModel;

class Mail extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function send()
    {
        $mail_model = new MailModel();

        $receive_email = "joydisk@gmail.com"; // 받는사람
        $title = "html 메일 보내기!!!"; // 제목
        $contents = "html로 메일을 보낼수 있어요."; // 내용

        $data = array();
        $data["receive_email"] = $receive_email;
        $data["title"] = $title;
        $data["contents"] = $contents;

        $model_result = $mail_model->procMailSend($data);

        return json_encode($model_result);
    }

}
