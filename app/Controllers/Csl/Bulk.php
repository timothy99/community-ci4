<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\BulkModel;
use App\Models\Common\PagingModel;
use App\Models\Common\DateModel;
use App\Models\Common\SpreadsheetModel;
use App\Models\Common\FileModel;

class Bulk extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/bulk/list");
    }

    public function list()
    {
        $bulk_model = new BulkModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";
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

        $model_result = $bulk_model->getBulkList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/csl/bulk/list"]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/bulk/list", $proc_result);
    }

    public function excelWrite()
    {
        $result = true;
        $message = "정상";

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;

        return aview("csl/bulk/write", $proc_result);
    }

    public function excelUpload()
    {
        $bulk_model = new BulkModel();

        $result = true;
        $message = "정상";

        $title = $this->request->getPost("title");
        $bulk_file = $this->request->getPost("bulk_file_hidden");

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($bulk_file == null) {
            $result = false;
            $message = "파일을 입력해주세요.";
        }

        $data = array();
        $data["title"] = $title;
        $data["bulk_file"] = $bulk_file;

        if ($result == true) {
            $model_result = $bulk_model->procBulkInsert($data);
            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/bulk/list";

        return json_encode($proc_result);
    }

    public function detail()
    {
        $bulk_model = new BulkModel();
        $paging_model = new PagingModel();
        $date_model = new DateModel();

        $b_idx = $this->request->getUri()->getSegment(4);

        $rows = $this->request->getGet("rows") ?? 10;
        $page = $this->request->getGet("page") ?? 1;
        $search_text = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        $search_condition = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "title";
        $search_condition = $search_condition == "null" ? "" : $search_condition; // null 이라는 텍스트로 들어와서 처리 함

        $search_arr = array();
        $search_arr["search_text"] = $search_text;
        $search_arr["search_condition"] = $search_condition;
        $search_arr["page"] = $page;
        $search_arr["rows"] = $rows;
        $search_arr["b_idx"] = $b_idx;
        $http_query = http_build_query($search_arr);

        $data = array();
        $data["rows"] = $rows;
        $data["page"] = $page;
        $data["search_arr"] = $search_arr;

        $model_result = $bulk_model->getBulkDetail($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows);
        }

        $paging = $paging_model->getPaging($page, $rows, $cnt);
        $paging_view = view("/csl/paging/paging", ["paging"=>$paging, "http_query"=>$http_query, "href_link"=>"/csl/bulk/detail/".$b_idx]); // 페이징 뷰

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging"] = $paging;
        $proc_result["paging_view"] = $paging_view;
        $proc_result["search_arr"] = $search_arr;

        return aview("csl/bulk/detail", $proc_result);
    }

    public function view()
    {
        $bulk_model = new BulkModel();
        $date_model = new DateModel();

        $bd_idx = $this->request->getUri()->getSegment(4); // segments 확인

        $result = true;
        $message = "정상";

        $model_result = $bulk_model->getBulkInfo($bd_idx);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $info = $model_result["info"];
        $info->ins_date_txt = $date_model->convertTextToDate($info->ins_date, 1, 1);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/bulk/view", $proc_result);
    }

    public function edit()
    {
        $bulk_model = new BulkModel();

        $bd_idx = $this->request->getUri()->getSegment(4);

        $result = true;
        $message = "정상";

        $model_result = $bulk_model->getBulkInfo($bd_idx);
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/bulk/edit", $proc_result);
    }

    public function update()
    {
        $bulk_model = new BulkModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $bd_idx = $this->request->getPost("bd_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $member_name = $this->request->getPost("member_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->request->getPost("email", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = $this->request->getPost("phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = $this->request->getPost("gender", FILTER_SANITIZE_SPECIAL_CHARS);
        $post_code = $this->request->getPost("post_code", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr1 = $this->request->getPost("addr1", FILTER_SANITIZE_SPECIAL_CHARS);
        $addr2 = $this->request->getPost("addr2", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
        $data["bd_idx"] = $bd_idx;
        $data["member_name"] = $member_name;
        $data["email"] = $email;
        $data["phone"] = $phone;
        $data["gender"] = $gender;
        $data["post_code"] = $post_code;
        $data["addr1"] = $addr1;
        $data["addr2"] = $addr2;

        if ($result == true) {
            $model_result = $bulk_model->procBulkUpdate($data);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/bulk/view/".$bd_idx;

        return json_encode($proc_result);
    }

    public function delete()
    {
        $bulk_model = new BulkModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $b_idx = $this->request->getUri()->getSegment(4); // segments 확인
        $bd_idx = $this->request->getUri()->getSegment(5); // segments 확인

        $data = array();
        $data["bd_idx"] = $bd_idx;

        if ($result == true) {
            $model_result = $bulk_model->procBulkDelete($data);
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/bulk/detail/".$b_idx;

        return json_encode($proc_result);
    }

}
