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

    public function view()
    {
        return uview("usr/member/view");
    }

    public function login()
    {
        // 이미 로그인을 한 상태라면 메인으로 보낸다.
        $auth_group = getUserSessionInfo("auth_group");
        if ($auth_group != "guest") {
            return redirect()->to("/");
        }

        return view("usr/member/login");
    }

    public function signin()
    {
        $member_model = new MemberModel();

        $result = true;
        $message = "정상처리";

        $member_id = $this->request->getPost("member_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_password = $this->request->getPost("member_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $ip_address = $this->request->getIPAddress();
        $return_url = getUserSessionInfo("previous_url");

        if ($member_id == null) {
            $result = false;
            $message = "아이디를 입력해주세요";
        }

        if ($member_password == null) {
            $result = false;
            $message = "암호를 입력해주세요";
        }

        if ($result == true) {
            $data = array();
            $data["member_id"] = $member_id;
            $data["member_password"] = $member_password;
            $data["ip_address"] = $ip_address;

            $model_result = $member_model->getMemberLoginInfo($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
            $member_info = $model_result["member_info"];

            if (isset($member_info->m_idx) == false) {
                $result = false;
                $message = "회원정보가 없거나 아이디 또는 암호가 틀립니다. 회원정보를 확인하세요.";
                $member_info = (object)array();
                $auth_group = "guest";
            } else {
                setUserSessionInfo("m_idx", $member_info->m_idx);
                setUserSessionInfo("member_id", $member_info->member_id);
                setUserSessionInfo("member_nickname", $member_info->member_nickname);
                setUserSessionInfo("auth_group", $member_info->auth_group);

                $auth_group = $member_info->auth_group;
            }

            $auth_group = getUserSessionInfo("auth_group");
            if ($auth_group == "admin") {
                $return_url = "/csl/dashboard/main";
            }
        } else {
            $result = false;
            $message = "회원정보가 없습니다. 회원정보를 확인하세요.";
            $member_info = (object)array();
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = $return_url;
        $proc_result["member_info"] = $member_info;

        return json_encode($proc_result);
    }

    public function join()
    {
        // 이미 로그인을 한 상태라면 메인으로 보낸다.
        $auth_group = getUserSessionInfo("auth_group");
        if ($auth_group != "guest") {
            return redirect()->to("/");
        }

        $data = array();
        $data["uri"] = $this->request->getUri()->getPath();

        return view("usr/member/join", $data);
    }

    public function signup()
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
            $model_result = $member_model->getMemberIdDuplicate($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

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
        return uview("usr/member/forgot");
    }

    // 로그아웃
    public function logout()
    {
        session_destroy();

        return redirect()->to("/home/home");
    }

}
