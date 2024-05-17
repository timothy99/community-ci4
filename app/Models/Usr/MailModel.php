<?php

namespace App\Models\Usr;

use CodeIgniter\Model;
use Throwable;

class MailModel extends Model
{
    public function procMailSend($data)
    {
        $email = \Config\Services::email(); // 이메일 서비스 로드

        $result = true;
        $message = "메일발송이 정상적으로 이루어졌습니다.";

        $receive_email = $data["receive_email"];
        $title = $data["title"];
        $contents = $data["contents"];

        $smtp_host = env("smtp.host"); // 호스트
        $smtp_user = env("smtp.user"); // 사용자 정보
        $smtp_pass = env("smtp.pass"); // 암호
        $smtp_port = env("smtp.port"); // 포트
        $smtp_name = env("smtp.name"); // 보내는 사람 이름

        $config["protocol"] = "smtp";
        $config["SMTPHost"] = $smtp_host; 
        $config["SMTPUser"] = $smtp_user;
        $config["SMTPPass"] = $smtp_pass;
        $config["SMTPPort"] = $smtp_port;
        $config["mailType"] = "html";

        try {
            $email->initialize($config);
            $email->setFrom($smtp_user, $smtp_name);
            $email->setTo($receive_email);
            $email->setSubject($title);
            $email->setMessage($contents);
            $result = $email->send();
        } catch (Throwable $t) {
            $result = false;
            $message = "메일발송에 오류가 발생했습니다.";
            logMessage($t->getMessage());
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return $proc_result;
    }

}
