<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\MemberModel;
use App\Models\Common\PagingModel;
use App\Models\Common\DateModel;
use App\Models\Common\SpreadsheetModel;

class Member extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $member_model = new MemberModel();
        $paging_model = new PagingModel();

        $data = array();
        $data["page"] = $this->request->getGet("page") ?? 1;

        $search_arr = array();
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "member_id";
        $search_arr["auth_group"] = $this->request->getGet("auth_group", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";

        $data["search_arr"] = $search_arr;

        $model_result = $member_model->getMemberList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        $data["cnt"] = $cnt;
        $paging_info = $paging_model->getPagingInfo($data);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging_info"] = $paging_info;
        $proc_result["data"] = $data;

        privacyInsert("대시보드 메인 접근");

        return aview("csl/member/list", $proc_result);
    }

    public function view()
    {
        $member_model = new MemberModel();

        $member_id = $this->request->getUri()->getSegment(4); // segments 확인

        $result = true;
        $message = "정상";

        $model_result = $member_model->getMemberInfo($member_id);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/member/view", $proc_result);
    }

    public function edit()
    {
        $member_model = new MemberModel();

        $member_id = $this->request->getUri()->getSegment(4); // segments 확인

        $result = true;
        $message = "정상";

        $model_result = $member_model->getMemberInfo($member_id);
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/member/edit", $proc_result);
    }

    public function update()
    {
        $member_model = new MemberModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $member_id = $this->request->getPost("member_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_name = $this->request->getPost("member_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_nickname = $this->request->getPost("member_nickname", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = $this->request->getPost("phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->request->getPost("email", FILTER_SANITIZE_SPECIAL_CHARS);
        $post_code = $this->request->getPost("post_code", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr1 = $this->request->getPost("addr1", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr2 = $this->request->getPost("addr2", FILTER_SANITIZE_SPECIAL_CHARS);
        $auth_group = $this->request->getPost("auth_group", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["member_id"] = $member_id;
        $data["member_name"] = $member_name;
        $data["member_nickname"] = $member_nickname;
        $data["phone"] = $phone;
        $data["email"] = $email;
        $data["post_code"] = $post_code;
        $data["addr1"] = $addr1;
        $data["addr2"] = $addr2;
        $data["auth_group"] = $auth_group;

        $model_result = $member_model->checkSigninInfo($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        if ($result == true) {
            $model_result = $member_model->procMemberUpdate($data);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/member/view/".$member_id;

        return json_encode($proc_result);
    }

    public function delete()
    {
        $member_model = new MemberModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $member_id = $this->request->getUri()->getSegment(4); // segments 확인

        $data = array();
        $data["member_id"] = $member_id;

        if ($result == true) {
            $model_result = $member_model->procMemberDelete($data);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/member/list";

        return json_encode($proc_result);
    }

    // 엑셀 다운로드
    public function excel()
    {
        $member_model = new MemberModel();
        $spreadsheet_model = new SpreadsheetModel();
        $date_model = new DateModel();

        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "member_id";
        $search_condition = $search_condition == "null" ? "" : $search_condition; // null 이라는 텍스트로 들어와서 처리 함
        $auth_group = $this->request->getGet("auth_group", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";

        $search_arr = array();
        $search_arr["search_text"] = $search_text;
        $search_arr["search_condition"] = $search_condition;
        $search_arr["auth_group"] = $auth_group;

        $data = array();
        $data["search_arr"] = $search_arr;
        $data["rows"] = 0;
        $data["page"] = 0;

        $model_result = $member_model->getMemberList($data);
        $list = $model_result["list"];

        $content_list = array();
        foreach($list as $no => $val) {
            $content = array();
            $content[] = $val->member_id;
            $content[] = $val->member_name;
            $content[] = $date_model->convertTextToDate($val->last_login_date, 1, 1);
            $content[] = $date_model->convertTextToDate($val->ins_date, 1, 1);
            $content[] = $val->auth_group;
            $content_list[] = $content;
        }

        $header_list = ["아이디", "성명", "로그인", "가입일", "회원등급"]; // 헤더
        $filename = "회원목록_".date("YmdHis").".xlsx"; // 엑셀로 받을 파일명
        $spreadsheet_model->procExcelWrite($content_list, $filename, $header_list); // 엑셀출력
    }

}
