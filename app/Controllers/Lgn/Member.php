<?php

namespace App\Controllers\Lgn;

use App\Controllers\BaseController;

use App\Models\Lgn\MemberModel;

class Member extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function view()
    {
        $member_model = new MemberModel();

        $model_result = $member_model->getMemberInfo();
        $info = $model_result["info"];

        $title_info = (object)array();
        $title_info->title = "회원정보";
        $title_info->head_title = " 회원정보 &gt; 보기 &gt; ".$info->member_id;
        $title_info->bread_crumb = "홈 &gt; 회원정보 &gt; 보기";

        $proc_result = array();
        $proc_result["result"] = $model_result["result"];
        $proc_result["message"] = $model_result["message"];
        $proc_result["info"] = $model_result["info"];
        $proc_result["title_info"] = $title_info;

        return mview("lgn/member/view", $proc_result);
    }

    public function login()
    {
        // 이미 로그인을 한 상태라면 메인으로 보낸다.
        $auth_group = getUserSessionInfo("auth_group");
        if ($auth_group != "guest") {
            return redirect()->to("/");
        }

        return mview("lgn/member/login");
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
            if (in_array($auth_group, ["관리자", "최고관리자"]) == true) {
                $return_url = "/csl";
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

        return mview("lgn/member/join", $data);
    }

    public function duplicate()
    {
        $member_model = new MemberModel();

        $member_id = $this->request->getPost("member_id");

        $data = array();
        $data["member_id"] = $member_id;

        $model_result = $member_model->getMemberIdDuplicate($data);

        return json_encode($model_result);
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

    // 로그아웃
    public function logout()
    {
        session_destroy();

        return redirect()->to("/");
    }

    public function edit()
    {
        $member_model = new MemberModel();

        $model_result = $member_model->getMemberInfo();
        $info = $model_result["info"];

        $title_info = (object)array();
        $title_info->title = "회원정보";
        $title_info->head_title = " 회원정보 &gt; 수정 &gt; ".$info->member_id;
        $title_info->bread_crumb = "홈 &gt; 회원정보 &gt; 수정";

        $proc_result = array();
        $proc_result["result"] = $model_result["result"];
        $proc_result["message"] = $model_result["message"];
        $proc_result["info"] = $model_result["info"];
        $proc_result["title_info"] = $title_info;

        return mview("lgn/member/edit", $proc_result);
    }

    public function update()
    {
        $member_model = new MemberModel();

        $result = false;
        $message = "정상처리";

        $member_name = $this->request->getPost("member_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_nickname = $this->request->getPost("member_nickname", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = $this->request->getPost("phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->request->getPost("email", FILTER_SANITIZE_SPECIAL_CHARS);
        $post_code = $this->request->getPost("post_code", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr1 = $this->request->getPost("addr1", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr2 = $this->request->getPost("addr2", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["member_name"] = $member_name;
        $data["member_nickname"] = $member_nickname;
        $data["phone"] = $phone;
        $data["email"] = $email;
        $data["post_code"] = $post_code;
        $data["addr1"] = $addr1;
        $data["addr2"] = $addr2;

        $model_result = $member_model->procMemberUpdate($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/member/view";

        return json_encode($proc_result);
    }

    public function leave()
    {
        $member_model = new MemberModel();

        $model_result = $member_model->getMemberInfo();

        $info = $model_result["info"];

        $title_info = (object)array();
        $title_info->title = "회원정보";
        $title_info->head_title = "회원정보 &gt; 탈퇴 &gt; ".$info->member_id;
        $title_info->bread_crumb = "홈 &gt; 회원정보 &gt; 탈퇴";

        $proc_result = array();
        $proc_result["result"] = $model_result["result"];
        $proc_result["message"] = $model_result["message"];
        $proc_result["info"] = $model_result["info"];
        $proc_result["title_info"] = $title_info;

        return mview("lgn/member/leave", $proc_result);
    }

    public function delete()
    {
        $member_model = new MemberModel();

        $result = true;
        $message = "정상처리";

        $member_model->procMemberDelete();

        session_destroy();

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/";

        return json_encode($proc_result);
    }

}
