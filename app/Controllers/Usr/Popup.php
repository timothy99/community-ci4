<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;

class Popup extends BaseController
{
    public function disabled()
    {
        $p_idx = $this->request->getUri()->getSegment(3, 0);
        $disabled_hours = $this->request->getUri()->getSegment(4, 72);
        $expire_date = date("YmdHis", strtotime("+".$disabled_hours." hours"));

        $result = true;
        $message = "정상";

        $data = (object)array();
        $data->p_idx = $p_idx;
        $data->disabled_hours = $disabled_hours;
        $data->expire_date = $expire_date;

        $layer_closed = getUserSessionInfo("layer_closed");
        array_push($layer_closed, $data);
        setUserSessionInfo("layer_closed", $layer_closed);

        $proc_result = array();
        $proc_result["result"] = $result;
        $proc_result["message"] = $message;


        return json_encode($proc_result);
    }

}
