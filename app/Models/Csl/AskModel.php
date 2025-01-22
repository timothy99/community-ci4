<?php

namespace App\Models\Csl;

use CodeIgniter\Model;
use App\Models\Common\DateModel;
use Exception;

class AskModel extends Model
{
    /**
     * 제공된 데이터를 기반으로 문의 목록을 가져옵니다.
     *
     * @param array $data 문의 목록을 가져오기 위한 데이터.
     * @return array 문의 목록 조회 결과.
     */
    public function getAskList($data)
    {
        $date_model = new DateModel();

        $result = true;
        $message = "목록 불러오기가 완료되었습니다.";

        $page = $data["page"];

        $search_arr = $data["search_arr"];
        $rows = $search_arr["rows"];
        $search_condition = $search_arr["search_condition"];
        $search_text = $search_arr["search_text"];

        $db = $this->db;
        $builder = $db->table("ask");
        $builder->where("del_yn", "N"); // 삭제되지 않은 항목만 조회
        if ($search_text != null) {
            $builder->like($search_condition, $search_text); // 검색 조건에 따라 검색
        }
        $builder->orderBy("a_idx", "desc"); // 최신 항목부터 정렬
        $builder->limit($rows, getOffset($page, $rows)); // 페이지네이션 적용
        $cnt = $builder->countAllResults(false); // 총 개수 조회
        $list = $builder->get()->getResult(); // 결과 목록 가져오기

        foreach($list as $no => $val) {
            $list[$no]->list_no = $cnt-$no-(($page-1)*$rows); // 목록 번호 계산
            $list[$no]->ins_date_txt = $date_model->convertTextToDate($val->ins_date, 1, 1); // 날짜 형식 변환
        }

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;
        $proc_result["list"] = $list;
        $proc_result["cnt"] = $cnt;

        return $proc_result;
    }

    /**
     * 문의 삭제를 처리합니다.
     *
     * @param array $data 문의 삭제를 위한 데이터.
     * @return array 문의 삭제 처리 결과.
     */
    public function procAskDelete($data)
    {
        $today = date("YmdHis");

        $result = true;
        $message = "입력이 잘 되었습니다";

        $a_idx = $data["a_idx"];

        try {
            $db = $this->db;
            $db->transStart(); // 트랜잭션 시작
            $builder = $db->table("ask");
            $builder->set("del_yn", "Y"); // 삭제 여부 설정
            $builder->set("upd_date", $today); // 업데이트 날짜 설정
            $builder->where("a_idx", $a_idx); // 특정 항목 선택
            $result = $builder->update(); // 업데이트 실행

            if ($result == false) { 
                throw new Exception($db->error()["message"]); // 오류 발생 시 예외 처리
            } else {
                $db->transComplete(); // 트랜잭션 완료
            }
        } catch (Exception $exception) {
            $result = false;
            $message = "입력에 오류가 발생했습니다.\n".$exception->getMessage();
            $db->transRollback(); // 트랜잭션 롤백
        }

        $model_result = array();
        $model_result["result"] = $result;
        $model_result["message"] = $message;

        return $model_result;
    }

}
