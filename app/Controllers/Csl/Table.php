<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;

class Table extends BaseController
{
    public function write()
    {
        return aview("csl/table/write");
    }

    public function view()
    {
        $table_tab = $this->request->getPost("table_tab");
        $row_arr = explode("\n", $table_tab);


        $column_arr = array();
        foreach ($row_arr as $no => $val) {
            if ($no == 0) {
                continue;
            } else if ($val == null) {
                continue;
            } else {
                $column_arr[] = explode("\t", $val);
            }
        }

        $table_arr = array();
        foreach ($column_arr as $no => $val) {
            $table_info = array();
            $table_info["table_name"] = $val[0];
            $table_info["table_type"] = $val[1];
            $table_info["table_comment"] = $val[2];

            $table_arr[$val[0]]["table_info"] = $table_info;
            $table_arr[$val[0]]["column_list"][] = array(
                "column_name" => $val[3],
                "column_type" => $val[4],
                "is_nullable" => $val[5],
                "column_default" => $val[6],
                "extra" => $val[7],
                "column_comment" => $val[8],
                "ordinal_position" => $val[9]
            );
        }
        $table_arr = array_values($table_arr);

        $proc_result = array();
        $proc_result["result"] = true;
        $proc_result["message"] = "목록 불러오기가 완료되었습니다.";
        $proc_result["table_arr"] = $table_arr;

        return aview("csl/table/view", $proc_result);
    }


}
