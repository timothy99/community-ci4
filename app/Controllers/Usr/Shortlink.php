<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;
use App\Models\Usr\ShortlinkModel;

class Shortlink extends BaseController
{
    public function index()
    {
        return redirect()->to("/");
    }

    public function hyperlink()
    {
        $shortlink_model = new ShortlinkModel();

        $sl_idx = $this->request->getUri()->getSegment(2);

        $model_result = $shortlink_model->getShortlinkInfo($sl_idx);

        return view("usr/shortlink/hyperlink", $model_result);
    }

}
