<?php

namespace App\Controllers\Usr;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to("/home/home");
    }

    public function home()
    {
        return view("usr/home");
    }

}
