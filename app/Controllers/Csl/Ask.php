<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\AskModel;
use App\Models\Common\PagingModel;

class Ask extends BaseController
{
    /**
     * 기본 경로로 리디렉션합니다.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function index()
    {
        // 기본 경로로 리디렉션
        return redirect()->to("/csl");
    }

    /**
     * 질문 목록을 가져와서 뷰에 전달합니다.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function list()
    {
        // 모델 인스턴스 생성
        $ask_model = new AskModel();
        $paging_model = new PagingModel();

        // 데이터 배열 초기화
        $data = array();
        // 현재 페이지 번호 가져오기, 기본값은 1
        $data["page"] = $this->request->getGet("page") ?? 1;

        // 검색 조건 배열 초기화
        $search_arr = array();
        // 한 페이지에 표시할 행 수, 기본값은 10
        $search_arr["rows"] = $this->request->getGet("rows") ?? 10;
        // 검색 텍스트 가져오기, 특수 문자 필터링
        $search_arr["search_text"] = $this->request->getGet("search_text", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
        // 검색 조건 가져오기, 기본값은 "name"
        $search_arr["search_condition"] = $this->request->getGet("search_condition", FILTER_SANITIZE_SPECIAL_CHARS) ?? "name";

        // 검색 조건을 데이터 배열에 추가
        $data["search_arr"] = $search_arr;

        // 질문 목록 가져오기
        $model_result = $ask_model->getAskList($data);
        $result = $model_result["result"];
        $message = $model_result["message"];
        $list = $model_result["list"];
        $cnt = $model_result["cnt"];

        // 데이터 배열에 결과 추가
        $data["cnt"] = $cnt;
        // 페이징 정보 가져오기
        $paging_info = $paging_model->getPagingInfo($data);

        // 처리 결과 배열 초기화
        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;
        $proc_result["paging_info"] = $paging_info;
        $proc_result["data"] = $data;

        // 뷰에 데이터 전달
        return aview("csl/ask/list", $proc_result);
    }

    /**
     * 질문을 삭제하고 결과를 JSON 형식으로 반환합니다.
     *
     * @return string JSON 형식의 결과
     */
    public function delete()
    {
        // 모델 인스턴스 생성
        $ask_model = new AskModel();

        // 기본 결과 값 설정
        $result = true;
        $message = "정상처리 되었습니다.";

        // URI에서 질문 인덱스 가져오기
        $a_idx = $this->request->getUri()->getSegment(4);

        // 데이터 배열 초기화
        $data = array();
        $data["a_idx"] = $a_idx;

        // 질문 삭제 처리
        $model_result = $ask_model->procAskDelete($data);
        $result = $model_result["result"];
        $message = $model_result["message"];

        // 처리 결과 배열 초기화
        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["return_url"] = "/csl/ask/list";

        // JSON 형식으로 결과 반환
        return json_encode($proc_result);
    }

}
