<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\MemberModel;

class Member extends BaseController
{
    public function index()
    {
        return redirect()->to("/member/myinfo");
    }

    public function myinfo()
    {
        return uview("usr/member/myinfo");
    }

    public function login()
    {
        return view("usr/member/login");
    }

    public function join()
    {
        $data = array();
        $data["uri"] = $this->request->getUri()->getPath();

        return view("usr/member/join", $data);
    }

    public function signin()
    {
        $member_model = new MemberModel();

        $result = false;
        $message = "정상처리";

        $member_id = $this->request->getPost("member_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_password = $this->request->getPost("member_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_password_confirm = $this->request->getPost("member_password_confirm", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_name = $this->request->getPost("member_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_nickname = $this->request->getPost("member_nickname", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = $this->request->getPost("phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->request->getPost("email", FILTER_SANITIZE_SPECIAL_CHARS);
        $post_code = $this->request->getPost("post_code", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr1 = $this->request->getPost("addr1", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr2 = $this->request->getPost("addr2", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["member_id"] = $member_id;
        $data["member_password"] = $member_password;
        $data["member_password_confirm"] = $member_password_confirm;
        $data["member_name"] = $member_name;
        $data["member_nickname"] = $member_nickname;
        $data["phone"] = $phone;
        $data["email"] = $email;
        $data["post_code"] = $post_code;
        $data["addr1"] = $addr1;
        $data["addr2"] = $addr2;

        $model_result = $member_model->checkSigninInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        if ($result == true) {
            $model_result = $member_model->procMember($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/";

        return json_encode($proc_result);
    }

    public function forgot()
    {
        return view("usr/member/forgot");
    }

}
