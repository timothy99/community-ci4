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
        return redirect()->to("/csl/member/list");
    }

    public function list()
    {
        $member_model = new MemberModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $segments = $this->request->getUri()->getSegments(); // segments 확인
        $board_id = $segments[2];

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "member_id";
        $search_condition = $search_condition == "null" ? "" : $search_condition; // null 이라는 텍스트로 들어와서 처리 함
        $auth_group = $this->request->getGet("auth_group", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";

        $search_arr = array();
        $search_arr["search_text"] = $search_text;
        $search_arr["search_condition"] = $search_condition;
        $search_arr["auth_group"] = $auth_group;
        $search_arr["page"] = $page;
        $search_arr["rows"] = $rows;
        $http_query = http_build_query($search_arr);

        $data = array();
        $data["rows"] = $rows;
        $data["page"] = $page;
        $data["search_arr"] = $search_arr;
        $data["board_id"] = $board_id;

        $model_result = $member_model->getMemberList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/member/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["board_id"] = $board_id;
        $proc_result["search_arr"] = $search_arr;

        privacyInsert("대시보드 메인 접근");

        return aview("csl/member/list", $proc_result);
    }

    public function view()
    {
        $member_model = new MemberModel();
        $date_model = new DateModel();

        $member_id = $this->request->getUri()->getSegment(4); // segments 확인

        $result = true;
        $message = "정상";

        $model_result = $member_model->getMemberInfo($member_id);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];
        $info->last_login_date_txt = $date_model->convertTextToDate($info->last_login_date, 1, 1);

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
