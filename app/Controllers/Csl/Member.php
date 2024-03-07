<?php

namespace App\Controllers\Csl;

use App\Controllers\BaseController;
use App\Models\Csl\MemberModel;

class Member extends BaseController
{
    public function index()
    {
        return redirect()->to("/csl/member/list");
    }

    public function list()
    {
        // 회원목록
        return aview("csl/member/list");
    }


}
