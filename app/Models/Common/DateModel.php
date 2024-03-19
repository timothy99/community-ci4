<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class DateModel extends Model
{
    // date_create_from_format 을 사용한 날짜 변경
    public function convertTextToDate($date_text, $input_type, $output_type)
    {
        if ($date_text == null) {
            $output_date = null;
        } else {
            if ($input_type == 1) {
                $input_date = date_create_from_format("YmdHis", $date_text);
            } elseif ($input_type == 2) {
                $input_date = date_create_from_format("Y-m-d H:i:s", $date_text);
            } elseif ($input_type == 3) {
                $input_date = date_create_from_format("Y-m-d", $date_text);
            } elseif ($input_type == 4) { // 2022-09-25T00:00:00+09:00 - fullcalendar UTC format
                $input_date = date_format(date_create($date_text), "Y-m-d");
                $input_date = date_create_from_format("Y-m-d", $input_date);
            } elseif ($input_type == 5) {
                $input_date = date_create_from_format("Ymd", $date_text);
            } elseif ($input_type == 6) {
                $input_date = date_create_from_format("Y-m-d", $date_text."-01");
            } elseif ($input_type == 7) {
                $input_date = date_create_from_format("Ymd", $date_text."01");
            } elseif ($input_type == 8) {
                $input_date = date_create_from_format("Y-m-d H:i:s", $date_text.":00");
            } elseif ($input_type == 9) { // 2022-09-25T00:00:00+09:00 - fullcalendar UTC format
                $input_date = date_format(date_create($date_text), "Y-m-d H:i");
                $input_date = date_create_from_format("Y-m-d H:i", $input_date);
            }

            if ($output_type == 1) {
                $output_date = $input_date->format("Y-m-d H:i:s");
            } elseif ($output_type == 2) {
                $output_date = $input_date->format("Y-m-d");
            } elseif ($output_type == 3) {
                $output_date = $input_date->format("YmdHis");
            } elseif ($output_type == 4) {
                $output_date = $input_date->format("Ymd")."000000";
            } elseif ($output_type == 5) {
                $output_date = $input_date->format("Ymd")."235959";
            } elseif ($output_type == 6) {
                $output_date = $input_date->format("Ymd");
            } elseif ($output_type == 7) {
                $output_date = $input_date->format("Y-m-d")."(".$input_date->format("D").")";
            } elseif ($output_type == 8) {
                $output_date = $input_date->format("Ym");
            } elseif ($output_type == 9) {
                $output_date = $input_date->format("Y-m");
            } elseif ($output_type == 10) {
                $output_date = $input_date->format("Y-m-d H:i");
            } elseif ($output_type == 11) {
                $output_date = $input_date->format("Y-m-d")."(".$input_date->format("D").") ".$input_date->format("H:i");
            }
        }

        return $output_date;
    }

    // strtotime 함수를 사용할 날짜 변경
    public function convertStringToDate($date_text, $output_type)
    {
        $input_date = strtotime($date_text);
        if ($output_type == 1) {
            $output_date = date("Y-m-d H:i:s", $input_date);
        } elseif ($output_type == 2) {
            $output_date = date("Y-m-d", $input_date);
        } elseif ($output_type == 3) {
            $output_date = date("YmdHis", $input_date);
        } elseif ($output_type == 4) {
            $output_date = date("Ymd", $input_date)."000000";
        } elseif ($output_type == 5) {
            $output_date = date("Ymd", $input_date)."235959";
        } elseif ($output_type == 6) {
            $output_date = date("Ymd", $input_date);
        }

        return $output_date;
    }
}
