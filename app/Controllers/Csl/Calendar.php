<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\CalendarModel;
use App\Models\Common\DateModel;

class Calendar extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl");
    }

    public function list()
    {
        $proc_result = array();

        return aview("csl/calendar/list", $proc_result);
    }

    // 달력에 표시할 일정 불러오기
    public function month()
    {
        $date_model = new DateModel();
        $calendar_model = new CalendarModel();

        $start_date = $this->request->getPost("start");
        $end_date = $this->request->getPost("end");

        $start_date = $date_model->convertTextToDate($start_date, 4, 4);
        $end_date = $date_model->convertTextToDate($end_date, 4, 5);

        $data = array();
        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;

        $model_result = $calendar_model->getCalendarList($data);
        $calendar = $model_result['list'];

        $list = array_merge($calendar);

        return json_encode($list);
    }

    // 일정쓰기
    public function write()
    {
        $segment4 = $this->request->getUri()->getSegment(4);

        $c_idx = 0;
        $start_date = "";
        $end_date = "";
        $title = "";
        $contents = "";
        $attach_file = "";

        $info = (object)array();
        $info->c_idx = $c_idx;
        $info->start_date = $start_date;
        $info->end_date = $end_date;
        $info->title = $title;
        $info->contents = $contents;
        $info->attach_file = $attach_file;
        $info->attach_file_info = null;

        $proc_result = array();
        $proc_result["info"] = $info;

        return aview("csl/calendar/edit", $proc_result);
    }

    // 일정업데이트
    public function update()
    {
        $calendar_model = new CalendarModel();

        $result = true;
        $message = "정상처리 되었습니다.";

        $c_idx = $this->request->getPost("c_idx", FILTER_SANITIZE_SPECIAL_CHARS);
        $start_date = $this->request->getPost("start_date", FILTER_SANITIZE_SPECIAL_CHARS);
        $end_date = $this->request->getPost("end_date", FILTER_SANITIZE_SPECIAL_CHARS);
        $title = $this->request->getPost("title", FILTER_SANITIZE_SPECIAL_CHARS);
        $contents = $this->request->getPost("contents", FILTER_SANITIZE_SPECIAL_CHARS);
        $attach_file = $this->request->getPost("attach_file_hidden", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($title == null) {
            $result = false;
            $message = "제목을 입력해주세요.";
        }

        if ($start_date > $end_date) {
            $result = false;
            $message = "종료일을 시작일보다 나중으로 입력해주세요.";
        }

        $data["c_idx"] = $c_idx;
        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["title"] = $title;
        $data["contents"] = $contents;
        $data["attach_file"] = $attach_file;

        if ($result == true) {
            if ($c_idx == 0) {
                $model_result = $calendar_model->procCalendarInsert($data);
                $c_idx = $model_result["insert_id"];
            } else {
                $model_result = $calendar_model->procCalendarUpdate($data);
            }

            $result = $model_result["result"];
            $message = $model_result["message"];
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["c_idx"] = $c_idx;
        $proc_result["return_url"] = "/csl/calendar/list";

        return json_encode($proc_result);
    }

    // 일정보기
    public function view()
    {
        $calendar_model = new CalendarModel();

        $result = true;
        $message = "정상";

        $c_idx = $this->request->getGet("no");

        $data = array();
        $data["c_idx"] = $c_idx;

        // 게시판 정보
        $model_result = $calendar_model->getCalendarInfo($data);
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/calendar/view", $proc_result);
    }

    // 일정수정
    public function edit()
    {
        $calendar_model = new CalendarModel();

        $result = true;
        $message = "정상";

        $c_idx = $this->request->getGet("no");

        $data = array();
        $data["c_idx"] = $c_idx;

        // 게시판 정보
        $model_result = $calendar_model->getCalendarInfo($data);
        $info = $model_result["info"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["info"] = $info;

        return aview("csl/calendar/edit", $proc_result);
    }

    public function delete()
    {
        $result = true;
        $message = "정상처리 되었습니다.";

        $calendar_model = new CalendarModel();

        $c_idx = $this->request->getUri()->getSegment(4, 0);

        $data = array();
        $data["c_idx"] = $c_idx;

        $model_result = $calendar_model->procCalendarDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/calendar/list";

        return json_encode($proc_result);
    }

}
