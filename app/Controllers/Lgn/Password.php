<?php

namespace App\Controllers\Lgn;

use App\Controllers\BaseController;
use App\Models\Lgn\PasswordModel;
use App\Models\Common\MailModel;

class Password extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    // 아이디 찾기
    public function find()
    {
        return mview("lgn/password/find");
    }

    // 아이디에 대한 이메일 보내기
    public function send()
    {
        $password_model = new PasswordModel();

        $result = true;
        $message = "해당 메일이 있는 경우 아이디 정보를 이메일로 보냅니다. 메일함을 확인해주세요.";

        $email = $this->request->getPost("email");

        $data = array();
        $data["email"] = $email;

        $model_result = $password_model->getMemberInfo($data);
        $info = $model_result["info"];

        // 회원정보가 있는 경우 메일을 보낸다.
        if ($info != null) {
            $mail_model = new MailModel();

            $receive_email = $info->email; // 받는사람
            $title = env("app.sitename")."에서 요청하신 아이디 정보입니다"; // 제목
            $contents = "요청하신 아이디 정보는 ".$info->member_id." 입니다. <br> <a href='".env("app.baseURL")."/member/login'>로그인하러가기</a>"; // 내용

            $data = array();
            $data["receive_email"] = $receive_email;
            $data["title"] = $title;
            $data["contents"] = $contents;

            $model_result = $mail_model->procMailSend($data);
        } else {
            // 검색해서 나오는 이메일 정보가 없는 경우 이메일을 보내지 않는다.
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/member/login";

        return json_encode($proc_result);
    }

    // 암호찾기
    public function forgot()
    {
        return mview("lgn/password/forgot");
    }

    // 암호 초기화 메일 보내기
    public function password()
    {
        $password_model = new PasswordModel();

        $result = true;
        $message = "해당 메일이 있는 경우 아이디 정보를 이메일로 보냅니다. 메일함을 확인해주세요.";

        $email = $this->request->getPost("email");
        $member_id = $this->request->getPost("member_id");

        $data = array();
        $data["email"] = $email;
        $data["member_id"] = $member_id;

        $model_result = $password_model->getPasswordInfo($data);
        $info = $model_result["info"];

        // 정보가 있는 경우 패스워드 초기화 정보를 등록한다.
        if ($info != null) {
            $model_result = $password_model->procResetInsert($data);
            $reset_key = $model_result["reset_key"];
        }

        // 회원정보가 있는 경우 메일을 보낸다.
        if ($info != null) {
            $mail_model = new MailModel();

            $receive_email = $info->email; // 받는사람
            $title = env("app.sitename")."에서 요청하신 초기화 정보입니다"; // 제목
            $contents = "초기화를 요청하셨습니다.<br><a href='".env("app.baseURL")."/password/reset/".$reset_key."' target='_blank'>여기</a>를 눌러 초기화를 진행하세요."; // 내용

            $data = array();
            $data["receive_email"] = $receive_email;
            $data["title"] = $title;
            $data["contents"] = $contents;

            $model_result = $mail_model->procMailSend($data);
        } else {
            // 검색해서 나오는 이메일 정보가 없는 경우 이메일을 보내지 않는다.
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/member/login";

        return json_encode($proc_result);
    }

    public function reset()
    {
        $password_model = new PasswordModel();

        $reset_key = $this->request->getUri()->getSegment(3);

        $data = array();
        $data["reset_key"] = $reset_key;

        $model_result = $password_model->getResetInfo($data);
        $info = $model_result["info"];

        if ($info === null) {
            redirect_alert("초기화 정보가 없습니다. 메일 요청을 여러번 하셨다면 가장 최근의 링크를 선택해주세요.", "/");
            exit;
        }

        $today = date("YmdHis");
        if ($info->expire_date < $today) {
            redirect_alert("유효기간이 만료되었습니다. 다시 요청해주세요.", "/");
        }

        return mview("lgn/password/reset", $data);
    }

    public function update()
    {
        $password_model = new PasswordModel();

        $result = true;
        $message = "정상처리";

        $reset_key = $this->request->getPost("reset_key", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_id = $this->request->getPost("member_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->request->getPost("email", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_password = (string)$this->request->getPost("member_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_password_confirm = $this->request->getPost("member_password_confirm", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($member_id == null) {
            $result = false;
            $message = "아이디를 입력해주세요.";
        }

        if ($email == null) {
            $result = false;
            $message = "이메일을 입력해주세요.";
        }

        if ($member_password != $member_password_confirm) {
            $result = false;
            $message = "입력된 비밀번호가 다릅니다.";
        }

        if (strlen($member_password) < 8) {
            $result = false;
            $message = "입력된 비밀번호는 8자리 이상이어야 합니다.";
        }

        $data = array();
        $data["reset_key"] = $reset_key;
        $data["member_password"] = $member_password;

        $model_result = $password_model->getResetInfo($data);
        $info = $model_result["info"];

        if ($info === null) {
            $result = false;
            $message = "초기화 정보가 없습니다";
        }

        $today = date("YmdHis");
        if ($info->expire_date < $today) {
            $result = false;
            $message = "유효기간이 만료되었습니다. 다시 요청해주세요.";
        }

        if ($result == true) {
            $model_result = $password_model->procPasswordReset($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/member/login";

        return json_encode($proc_result);
    }

    // 암호변경을 위한 암호 확인 화면
    public function confirm()
    {
        return mview("lgn/password/confirm");
    }

    // 암호가 맞는지 확인
    public function search()
    {
        $password_model  = new PasswordModel();

        $result = true;
        $message = "정상처리";

        $member_id = getUserSessionInfo("member_id");
        $member_password = $this->request->getPost("member_password");

        $data = array();
        $data["member_id"] = $member_id;
        $data["member_password"] = $member_password;

        $model_result = $password_model->getMemberPasswordInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/password/modify";

        return json_encode($proc_result);
    }

    // 암호변경을 위한 암호 확인 화면
    public function modify()
    {
        return mview("lgn/password/modify");
    }

    // 암호를 알고 있는 상태에서의 암호 변경
    public function change()
    {
        $password_model  = new PasswordModel();

        $result = true;
        $message = "정상처리";

        $member_id = getUserSessionInfo("member_id");
        $member_password = (string)$this->request->getPost("member_password");
        $member_password_confirm = $this->request->getPost("member_password_confirm");

        if ($member_password != $member_password_confirm) {
            $result = false;
            $message = "입력된 비밀번호가 다릅니다.";
        }

        if (strlen($member_password) < 8) {
            $result = false;
            $message = "입력된 비밀번호는 8자리 이상이어야 합니다.";
        }

        if ($result == true) {
            $data = array();
            $data["member_id"] = $member_id;
            $data["member_password"] = $member_password;

            $model_result = $password_model->procPasswordUpdate($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/";

        session_destroy();

        return json_encode($proc_result);
    }

}
